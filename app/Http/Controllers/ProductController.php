<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    use ApiResponse;

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        try {
            $result = $this->productService->getAllProduct($request);

            if ($result->isEmpty()) {
                return $this->successResponse("No Product found", 200);
            }

            return $this->successResponse("Product list fetched successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $result = $this->productService->createProduct($request->all());

            return $this->successResponse("Product Created successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }

    public function update(UpdateProductRequest $request)
    {

        try {
            $result = $this->productService->updateProduct($request->id, $request->all());

            return $this->successResponse("Product Updated successfully!!", 200, $result);
        } catch (\Exception $e) {

            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }


    public function delete(Request $request)
    {
        try {
            $result = $this->productService->deleteProduct($request->id);
            if ($result) {
                return $this->successResponse("Product Deleted successfully!!", 200);
            }
        } catch (\Exception $e) {
            return $this->errorResponse('Server Error', 500, $e->getMessage());
        }
    }
}
