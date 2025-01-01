<?php

namespace App\Repositories\Contracts;

use App\Models\Product;

interface ProductRepositoryInterface
{
    // public function all(): array;

    // public function find(int $id): ?Product;

    public function create(array $data): Product;

    // public function update(int $id, array $data): bool;

    // public function delete(int $id): bool;
}
