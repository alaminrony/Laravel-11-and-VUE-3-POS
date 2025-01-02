<?php

namespace App\Repositories\Eloquent;

use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function getAllSupplier(array $filterData)
    {

        try {
            $Suppliers = Supplier::query();

            if (!empty($filterData['name'])) {
                $Suppliers = $Suppliers->where('name', 'LIKE', "%{$filterData['name']}%");
            }

            $Suppliers = $Suppliers->paginate(10);

            return $Suppliers;
        } catch (\Exception $e) {

            logger()->error('Error fetching Suppliers: ' . $e->getMessage());
            throw $e;
        }
    }

    public function find(int $id)
    {
        try {
            return Supplier::find($id);
        } catch (\Exception $e) {
            logger()->error("Error finding Supplier with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $Supplier                            = new Supplier;
            $Supplier->name                      = $data['name'];
            $Supplier->contact_info              = $data['contact_info'] ?? '';
            $Supplier->address                   = $data['address'] ?? '';
            $Supplier->save();

            DB::commit();
            return $Supplier;

        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error creating Supplier: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $Supplier = $this->find($id);

            if (!$Supplier) {
                throw new \Exception("Supplier with ID {$id} not found.");
            }

            $Supplier->name                      = $data['name'];
            $Supplier->contact_info              = $data['contact_info'] ?? '';
            $Supplier->address                   = $data['address'] ?? '';
            $Supplier->save();


            DB::commit();

            return $Supplier;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Error updating Supplier with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $Supplier = $this->find($id);

            if (!$Supplier) {
                throw new \Exception("Supplier with ID {$id} not found.");
            }

            $result = $Supplier->delete();
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Error deleting Supplier with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}
