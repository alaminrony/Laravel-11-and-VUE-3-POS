<?php

namespace App\Services;

use App\Repositories\Contracts\SupplierRepositoryInterface;

class SupplierService
{
    /**
     * Create a new class instance.
     */
    protected SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function getAllSupplier($request)
    {

        try {
            $filterData = $request->only(['name']);

            return $this->supplierRepository->getAllSupplier($filterData);

        } catch (\Exception $e) {
            logger()->error('Error in SupplierService@getAllSupplier: ' . $e->getMessage());
            throw new \Exception('Unable to fetched Supplier. '. $e->getMessage());
        }
    }

    public function createSupplier(array $data)
    {
        try {
            return $this->supplierRepository->create($data);

        } catch (\Exception $e) {
            logger()->error('Error in SupplierService@createSupplier: ' . $e->getMessage());
            throw new \Exception('Unable to create Supplier. '. $e->getMessage());
        }
    }

    public function updateSupplier(int $id, array $data)
    {

        try {
            return $this->supplierRepository->update($id,$data);

        } catch (\Exception $e) {
            logger()->error('Error in SupplierService@updateSupplier: ' . $e->getMessage());
            throw new \Exception('Unable to update Supplier. '. $e->getMessage());
        }
    }

    public function deleteSupplier(int $id)
    {

        try {
            return $this->supplierRepository->delete($id);

        } catch (\Exception $e) {
            logger()->error('Error in SupplierService@deleteSupplier: ' . $e->getMessage());
            throw new \Exception('Unable to delete Supplier. '. $e->getMessage());
        }
    }
}
