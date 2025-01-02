<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\SupplierService;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;

class SupplierController extends Controller
{
    use ApiResponse;

    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index(Request $request)
    {
        try {
            $result = $this->supplierService->getAllSupplier($request);

            if ($result->isEmpty()) {
                return $this->successResponse("No Supplier found", 200);
            }

            return $this->successResponse("Supplier list fetched successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }

    public function store(StoreSupplierRequest $request)
    {
        try {
            $result = $this->supplierService->createSupplier($request->all());

            return $this->successResponse("Supplier Created successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }

    public function update(UpdateSupplierRequest $request)
    {

        try {
            $result = $this->supplierService->updateSupplier($request->id, $request->all());

            return $this->successResponse("Supplier Updated successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }


    public function delete(Request $request)
    {
        try {
            $result = $this->supplierService->deleteSupplier($request->id);
            if ($result) {
                return $this->successResponse("Supplier Deleted successfully!!", 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }
}
