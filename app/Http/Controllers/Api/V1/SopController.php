<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SopRequest;
use App\Http\Resources\SopResource;
use App\Models\Sop;
use Illuminate\Http\JsonResponse;

class SopController extends Controller
{
    protected array $relations = ["customer"];

    protected array $fileFieldNames = ["pdf"];

    protected array $fileFolderPaths = ["sops"];

    public function index(): JsonResponse {
        $sops = $this->paginateOrGet(Sop::filter()->latest());

        return $this->respondWithResourceCollection(
            SopResource::collection($sops)
        );
    }

    /**
     * Store a newly created sop in storage.
     */
    public function store(SopRequest $request): JsonResponse {
        $sop = new Sop($request->validated());
        $this->storeFiles($request, $sop);
        $sop->save();

        return $this->respondCreated(
            new SopResource($sop),
            "Sop created successfully!"
        );
    }

    /**
     * Display the specified sop.
     */
    public function show(Sop $sop): JsonResponse {
        return $this->respondWithResource(new SopResource($sop));
    }

    /**
     * Update the specified sop in storage.
     */
    public function update(SopRequest $request, Sop $sop): JsonResponse {
        $sop->fill($request->validated());
        $this->updateFiles($request, $sop);
        $sop->save();

        return $this->respondUpdated(
            new SopResource($sop),
            "Sop updated successfully!"
        );
    }

    /**
     * Remove the specified sop from storage.
     */
    public function destroy(Sop $sop): JsonResponse {
        $this->deleteFiles($sop);
        $sop->delete();

        return $this->respondSuccess("Sop deleted successfully!");
    }
}
