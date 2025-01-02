<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    /**
     * Create a new class instance.
     */
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProduct($request)
    {

        try {
            $filterData = $request->only(['name','SKU']);

            return $this->productRepository->getAllProduct($filterData);

        } catch (\Exception $e) {
            logger()->error('Error in ProductService@getAllProduct: ' . $e->getMessage());
            throw new \Exception('Unable to fetched Product. '. $e->getMessage());
        }
    }

    public function createProduct(array $data)
    {
        try {
            return $this->productRepository->create($data);

        } catch (\Exception $e) {
            logger()->error('Error in ProductService@createProduct: ' . $e->getMessage());
            throw new \Exception('Unable to create Product. '. $e->getMessage());
        }
    }

    public function updateProduct(int $id, array $data)
    {

        try {
            return $this->productRepository->update($id,$data);

        } catch (\Exception $e) {
            logger()->error('Error in ProductService@updateProduct: ' . $e->getMessage());
            throw new \Exception('Unable to update Product. '. $e->getMessage());
        }
    }

    public function deleteProduct(int $id)
    {

        try {
            return $this->productRepository->delete($id);

        } catch (\Exception $e) {
            logger()->error('Error in ProductService@deleteProduct: ' . $e->getMessage());
            throw new \Exception('Unable to delete Product. '. $e->getMessage());
        }
    }
}
