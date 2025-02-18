<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected array $relations = [
        "createdBy", "customer",
    ];
    protected ?string $resourceName = "users";

    protected array $fileFieldNames = ["photo"];

    protected array $fileFolderPaths = ["photos"];

    /**
     * Display a listing of the users.
     */
    public function index(): JsonResponse {
        $users = $this->paginateOrGet(
            User::with($this->getRelations())->filter()->latest());

        return $this->respondWithResourceCollection(
            UserResource::collection($users)
        );
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserRequest $request): JsonResponse {
        $user = new User($request->validated());
        $this->storeFiles($request, $user);
        $user->save();

        return $this->respondCreated(
            new UserResource($user),
            "User created successfully!"
        );
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): JsonResponse {
        $user->loadMissing($this->getRelations());

        return $this->respondWithResource(new UserResource($user));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserRequest $request, User $user): JsonResponse {
        $user->fill($request->validated());

        $this->updateFiles($request, $user);
        $user->save();

        return $this->respondUpdated(
            new UserResource($user),
            "User updated successfully!"
        );
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): JsonResponse {
        $this->deleteFiles($user);
        $user->delete();

        return $this->respondSuccess("User deleted successfully!");
    }

    public function profile(Request $request) {
        $user = $request->user()->loadMissing($this->getRelations());

        return $this->respondWithResource(new UserResource($user));
    }
}
