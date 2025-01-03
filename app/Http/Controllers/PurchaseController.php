<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\PurchaseService;
use App\Http\Requests\Purchase\StorePurchaseRequest;


class PurchaseController extends Controller
{
    use ApiResponse;

    protected PurchaseService $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function index(Request $request)
    {

        try {
            $result = $this->purchaseService->getAllPurchase($request);

            if ($result->isEmpty()) {
                return $this->successResponse("No Purchase found", 200);
            }

            return $this->successResponse("Purchase list fetched successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }

    public function show(Request $request)
    {

        try {
            $result = $this->purchaseService->showPurchase($request->id);

            if (!$result) {
                return $this->successResponse("No Purchase found", 200);
            }

            return $this->successResponse("Purchase details fetched successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }

    public function store(StorePurchaseRequest $request)
    {

        try {
            $result = $this->purchaseService->createPurchase($request->all());

            return $this->successResponse("Purchase Created successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }
}
