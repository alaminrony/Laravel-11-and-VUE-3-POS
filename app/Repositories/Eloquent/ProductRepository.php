<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    // public function all(): array
    // {
    //     try {
    //         return Product::all()->toArray();
    //     } catch (\Exception $e) {
    //         // Log the error and rethrow for higher-level handling
    //         logger()->error('Error fetching Products: ' . $e->getMessage());
    //         throw $e;
    //     }
    // }

    // public function find(int $id): ?Product
    // {
    //     try {
    //         return Product::find($id);
    //     } catch (\Exception $e) {
    //         logger()->error("Error finding Product with ID {$id}: " . $e->getMessage());
    //         throw $e;
    //     }
    // }

    public function create(array $data): Product
    {


        DB::beginTransaction();

        try {
            $product                            = new Product;
            $product->name                      = $data['name'];
            $product->SKU                       = $data['SKU'];
            $product->price                     = $data['price'];
            $product->initial_stock_quantity    = $data['initial_stock_quantity'] ?? 0;
            $product->current_stock_quantity    = $data['current_stock_quantity'] ?? 0;
            $product->category_id               = $data['category_id'] ?? NULL;
            $product->save();

            DB::commit();
            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error creating Product: ' . $e->getMessage());
            throw $e;
        }
    }

    // public function update(int $id, array $data): bool
    // {
    //     DB::beginTransaction();

    //     try {
    //         $Product = $this->find($id);

    //         if (!$Product) {
    //             throw new \Exception("Product with ID {$id} not found.");
    //         }

    //         $result = $Product->update($data);
    //         DB::commit();

    //         return $result;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger()->error("Error updating Product with ID {$id}: " . $e->getMessage());
    //         throw $e;
    //     }
    // }

    // public function delete(int $id): bool
    // {
    //     DB::beginTransaction();

    //     try {
    //         $Product = $this->find($id);

    //         if (!$Product) {
    //             throw new \Exception("Product with ID {$id} not found.");
    //         }

    //         $result = $Product->delete();
    //         DB::commit();

    //         return $result;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         logger()->error("Error deleting Product with ID {$id}: " . $e->getMessage());
    //         throw $e;
    //     }
    // }
}
