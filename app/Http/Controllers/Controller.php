<?php

namespace App\Http\Controllers;

use App\Http\Traits\CanManageFile;
use App\Http\Traits\Response\HasApiResponse;
use App\Http\Traits\Response\HasExceptionResponse;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class Controller
{
    use CanManageFile, HasApiResponse, HasExceptionResponse;

    protected array $relations = [];

    protected function paginateOrGet(Builder|Model|BelongsToMany|HasMany $query)
    {
        $page = request()->query('page');
        $perPage = request()->query('perPage', 15); // Default perPage to 15 if not provided

        return $query->when(
            $page,
            fn(Builder $q) => $q->paginate($perPage),
            fn(Builder $q) => $q->get()
        );
    }

    protected function getRelations(): array
    {
        // Get the 'relations' query parameter from the request
        $relationsToLoad = request()->query('relations');

        // If the 'relations' parameter is '*' (all relations), return all predefined relations
        if ($relationsToLoad === '*') {
            return $this->relations;
        }

        // return an empty array if no relations are specified
        if (!$relationsToLoad) {
            return [];
        }

        // split provided relations into an array and map to camelCase
        return array_map(
            fn($relation) => Str::camel($relation),
            explode(',', $relationsToLoad)
        );
    }

    protected function transactional(callable $callback): Model|JsonResponse|null
    {
        DB::beginTransaction();
        try {
            // Execute the callback
            $result = $callback();

            DB::commit(); // commit the transaction
            return $result; // return the result of the callback
        } catch (Exception $e) {
            DB::rollBack(); // rollback the transaction

            // log the error
            Log::error($e->getMessage());

            return $this->respondError(
                "Action failed: " . $e->getMessage(),
                $e
            );
        }
    }
}
