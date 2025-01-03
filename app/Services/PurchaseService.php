<?php

namespace App\Services;

use App\Repositories\Contracts\PurchaseRepositoryInterface;

class PurchaseService
{
     /**
     * Create a new class instance.
     */
    protected PurchaseRepositoryInterface $purchaseRepository;

    public function __construct(PurchaseRepositoryInterface $purchaseRepository)
    {
        $this->purchaseRepository = $purchaseRepository;
    }

    public function getAllPurchase($request)
    {

        try {
            $filterData = $request->only(['supplier_id','from_date','to_date']);

            return $this->purchaseRepository->getAllPurchase($filterData);

        } catch (\Exception $e) {
            logger()->error('Error in PurchaseService@getAllPurchase: ' . $e->getMessage());
            throw new \Exception('Unable to fetched Purchase. '. $e->getMessage());
        }
    }

    public function createPurchase(array $data)
    {
        try {
            return $this->purchaseRepository->create($data);

        } catch (\Exception $e) {
            logger()->error('Error in PurchaseService@createPurchase: ' . $e->getMessage());
            throw new \Exception('Unable to create Purchase. '. $e->getMessage());
        }
    }

    public function showPurchase(int $id)
    {
        try {
            return $this->purchaseRepository->find($id);

        } catch (\Exception $e) {
            logger()->error('Error in PurchaseService@showPurchase: ' . $e->getMessage());
            throw new \Exception('Unable to fetch Purchase details. '. $e->getMessage());
        }
    }


}
