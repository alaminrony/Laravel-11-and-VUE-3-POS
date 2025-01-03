<?php

namespace App\Repositories\Contracts;



interface PurchaseRepositoryInterface
{
    public function getAllPurchase(array $filterData);

    public function find(int $id);

    public function create(array $data);
}
