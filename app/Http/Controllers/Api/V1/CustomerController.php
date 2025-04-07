<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected array $relations = ["rm", "underWriter", "channelPartner"];
    
    public function index(): JsonResponse {
        $customers = $this->paginateOrGet(Customer::latest());

        return $this->respondWithResourceCollection(
            CustomerResource::collection($customers)
        );
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(CustomerRequest $request): JsonResponse {
        $customer = Customer::create($request->validated());

        return $this->respondCreated(
            new CustomerResource($customer),
            "Customer created successfully!"
        );
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): JsonResponse {
        return $this->respondWithResource(new CustomerResource($customer));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(CustomerRequest $request, Customer $customer): JsonResponse {
        $customer->update($request->validated());

        return $this->respondUpdated(
            new CustomerResource($customer),
            "Customer updated successfully!"
        );
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer): JsonResponse {
        $customer->delete();

        return $this->respondSuccess("Customer deleted successfully!");
    }
}
