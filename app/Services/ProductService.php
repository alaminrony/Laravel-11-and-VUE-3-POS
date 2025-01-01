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

    public function createProduct(array $data)
    {
        try {
            return $this->productRepository->create($data);

        } catch (\Exception $e) {
            logger()->error('Error in ProductService@createUser: ' . $e->getMessage());
            throw new \Exception('Unable to create Product');
        }
    }
}
