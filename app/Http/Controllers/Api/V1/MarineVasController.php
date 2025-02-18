<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarineVasRequest;
use App\Http\Resources\MarineVasResource;
use App\Models\MarineVas;
use Illuminate\Http\JsonResponse;

class MarineVasController extends Controller
{
    public function index(): JsonResponse {
        $marineVas = $this->paginateOrGet(MarineVas::latest());

        return $this->respondWithResourceCollection(
            MarineVasResource::collection($marineVas)
        );
    }

    /**
     * Store a newly created marineVas in storage.
     */
    public function store(MarineVasRequest $request): JsonResponse {
        $marineVas = MarineVas::create($request->validated());

        return $this->respondCreated(
            new MarineVasResource($marineVas),
            "Marine VAS created successfully!"
        );
    }

    /**
     * Display the specified marineVas.
     */
    public function show(MarineVas $marineVas): JsonResponse {
        return $this->respondWithResource(new MarineVasResource($marineVas));
    }

    /**
     * Update the specified marineVas in storage.
     */
    public function update(MarineVasRequest $request, MarineVas $marineVas): JsonResponse {
        $marineVas->update($request->validated());

        return $this->respondUpdated(
            new MarineVasResource($marineVas),
            "Marine VAS updated successfully!"
        );
    }

    /**
     * Remove the specified marineVas from storage.
     */
    public function destroy(MarineVas $marineVas): JsonResponse {
        $marineVas->delete();

        return $this->respondSuccess("Marine VAS deleted successfully!");
    }
}
