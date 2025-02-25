<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MlceIndentUserType;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlceIndentRequest;
use App\Http\Resources\MlceIndentResource;
use App\Models\MlceIndent;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class MlceIndentController extends Controller
{
    protected array $relations = [
        "createdBy", "customer", "mlceType", "users", "locations", "assignments", "report",
    ];

    protected ?string $resourceName = "mlce-indents";

    protected array $fileFieldNames = [
        "pdr_observation",
    ];

    protected array $fileFolderPaths = [
        "pdr-observations",
    ];

    /**
     * Display a listing of the mlceIndents.
     */
    public function index(): JsonResponse {
        $mlceIndents = $this->paginateOrGet(
            MlceIndent::with($this->getRelations())->filter()->latest());

        return $this->respondWithResourceCollection(
            MlceIndentResource::collection($mlceIndents)
        );
    }

    /**
     * Store a newly created mlceIndent in storage.
     */
    public function store(MlceIndentRequest $request): JsonResponse {
        $mlceIndent = $this->transactional(function () use ($request) {
            $mlceIndent = new MlceIndent($request->validated());
            $this->storeFiles($request, $mlceIndent);
            $mlceIndent->save();

            // attach provided users
            $this->attachOrSyncUsers($mlceIndent, $request);

            // create mlce locations if provided
            if ($request->has("locations")) {
                $mlceIndent->locations()->createMany($request->validated("locations"));
            }

            $mlceIndent->report()->create(["customer_id" => $mlceIndent->customer_id]);

            return $mlceIndent;
        });

        if ($mlceIndent instanceof JsonResponse) {
            return $mlceIndent;
        }

        return $this->respondCreated(
            new MlceIndentResource($mlceIndent),
            "MlceIndent created successfully!"
        );
    }

    protected function attachOrSyncUsers(
        MlceIndent $mlceIndent,
        MlceIndentRequest $request,
        string $method = "attach",
    ) {
        if (!$request->has("users")) {
            return;
        }

        $userData = collect($request->validated("users"))->mapWithKeys(function (array $userData) {
            // if the user type is not Guest or user_id is provided, attach the existing user
            if (isset($userData["user_id"]) || $userData["type"] !== MlceIndentUserType::GUEST->value) {
                return [$userData["user_id"] => ["type" => $userData["type"]]];
            }

            // create a new guest user if type is Guest and user_id is empty
            $guestUser = User::firstOrCreate([
                "email" => $userData["email"],
                "mobile_no" => $userData["mobile_no"]
            ], [
                'name' => $userData['name'],
                'email' => $userData['email'],
                'mobile_no' => $userData['mobile_no'],
                'role' => UserRole::GUEST,
                'password' => $userData["mobile_no"],
            ]);

            // return the new guest user data to be attached
            return [$guestUser->id => ['type' => $userData['type']]];
        });

        $mlceIndent->users()->$method($userData);
    }

    /**
     * Display the specified mlceIndent.
     */
    public function show(MlceIndent $mlceIndent): JsonResponse {
        $mlceIndent->load($this->getRelations());

        return $this->respondWithResource(new MlceIndentResource($mlceIndent));
    }

    /**
     * Update the specified mlceIndent in storage.
     */
    public function update(MlceIndentRequest $request, MlceIndent $mlceIndent): JsonResponse {
        $mlceIndent = $this->transactional(function () use ($mlceIndent, $request) {
            $mlceIndent->fill($request->validated());
            $this->updateFiles($request, $mlceIndent);
            $mlceIndent->save();

            // sync provided users
            $this->attachOrSyncUsers($mlceIndent, $request, "sync");

            if (!$request->has("locations")) {
                return $mlceIndent;
            }

            // collect all the location ids of mlce indent
            $locationIds = collect($request->validated("locations"))
                ->map(function ($location) use ($mlceIndent, $request) {
                    $mlceIndentLocation = $mlceIndent->locations()
                        ->updateOrCreate(["id" => $location["id"] ?? null], $location);

                    return $mlceIndentLocation->id;
                })->toArray();

            // delete all the locations that do not exist in $locationIds
            $mlceIndent->locations()->whereNotIn("id", $locationIds)->delete();

            return $mlceIndent;
        });

        if ($mlceIndent instanceof JsonResponse) {
            return $mlceIndent;
        }

        return $this->respondUpdated(
            new MlceIndentResource($mlceIndent),
            "MlceIndent updated successfully!"
        );
    }

    /**
     * Remove the specified mlceIndent from storage.
     */
    public function destroy(MlceIndent $mlceIndent): JsonResponse {
        $this->deleteFiles($mlceIndent);
        $mlceIndent->delete();

        return $this->respondSuccess("MlceIndent deleted successfully!");
    }
}
