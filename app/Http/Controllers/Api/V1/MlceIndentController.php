<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\MlceIndentRequest;
use App\Http\Resources\MlceIndentResource;
use App\Models\MlceIndent;
use Illuminate\Http\JsonResponse;

class MlceIndentController extends Controller
{
    protected array $relations = [
        "createdBy", "customer", "mlceType", "insuredRepresentative", "rm", "verticalRm",
        "underWriter", "allowedUsers", "locations", "assignments", "report",
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
        $user = request()->user();
        $query = MlceIndent::query();

        if ($user->role === UserRole::MARINE_EXT_TEAM_MEMBER->value) {
            $query->orWhereHas("assignments", fn($query) => $query->where("inspector_id", $user->id));
        } elseif ($user->role !== UserRole::ILGIC_MLCE_ADMIN->value) {
            $query->whereHas("allowedUsers", fn($query) => $query->where("users.id", $user->id));
        }

        $mlceIndents = $this->paginateOrGet(
            $query->with($this->getRelations())->filter()->latest("id"));

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
            if ($request->has("allowed_users")) {
                $mlceIndent->allowedUsers()->attach($request->validated("allowed_users"));
            }

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
            if ($request->has("allowed_users")) {
                $mlceIndent->allowedUsers()->sync($request->validated("allowed_users"));
            }

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
