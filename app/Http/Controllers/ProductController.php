<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    use ApiResponse;

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $result = $this->productService->createProduct($request->all());

            return $this->successResponse("Product Created successfully!!",200,$result);
        } catch (\Exception $e) {

            return $this->errorResponse('Something went wrong!!',500, $e->getMessage());
        }
    }
}
