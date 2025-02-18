<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MlceIndentUserRequest;
use App\Http\Resources\MlceIndentUserResource;
use App\Models\MlceIndentUser;

class MlceIndentUserController extends Controller
{
    public function index() {
        return MlceIndentUserResource::collection(MlceIndentUser::all());
    }

    public function store(MlceIndentUserRequest $request) {
        return new MlceIndentUserResource(MlceIndentUser::create($request->validated()));
    }

    public function show(MlceIndentUser $mlceIndentUser) {
        return new MlceIndentUserResource($mlceIndentUser);
    }

    public function update(MlceIndentUserRequest $request, MlceIndentUser $mlceIndentUser) {
        $mlceIndentUser->update($request->validated());

        return new MlceIndentUserResource($mlceIndentUser);
    }

    public function destroy(MlceIndentUser $mlceIndentUser) {
        $mlceIndentUser->delete();

        return response()->json();
    }
}
