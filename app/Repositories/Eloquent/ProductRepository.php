<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

    public function getAllProduct(array $filterData)
    {

        try {
            $products = Product::query();

            if (!empty($filterData['name'])) {
                $products = $products->where('name', 'LIKE', "%{$filterData['name']}%");
            }

            if (!empty($filterData['SKU'])) {
                $products = $products->where('SKU', 'LIKE', "%{$filterData['SKU']}%");
            }

            $products = $products->paginate(10);

            return $products;
        } catch (\Exception $e) {

            logger()->error('Error fetching Products: ' . $e->getMessage());
            throw $e;
        }
    }

    public function find(int $id)
    {
        try {
            return Product::find($id);
        } catch (\Exception $e) {
            logger()->error("Error finding Product with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $product                            = new Product;
            $product->name                      = $data['name'];
            $product->SKU                       = $data['SKU'];
            $product->price                     = $data['price'];
            $product->initial_stock_quantity    = $data['initial_stock_quantity'] ?? 0;
            $product->current_stock_quantity    = $data['initial_stock_quantity'] ?? 0;
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

    public function update(int $id, array $data)
    {
        DB::beginTransaction();

        try {
            $product = $this->find($id);

            if (!$product) {
                throw new \Exception("Product with ID {$id} not found.");
            }

            $product->name                      = $data['name'];
            $product->SKU                       = $data['SKU'];
            $product->price                     = $data['price'];

            if($product->initial_stock_quantity < $data['initial_stock_quantity']){
                $product->current_stock_quantity    = $product->current_stock_quantity + ($data['initial_stock_quantity'] - $product->initial_stock_quantity);
            }elseif($product->initial_stock_quantity > $data['initial_stock_quantity']){
                $product->current_stock_quantity    = $product->current_stock_quantity - ($product->initial_stock_quantity - $data['initial_stock_quantity']);
            }

            $product->initial_stock_quantity    = $data['initial_stock_quantity'] ?? 0;
            $product->category_idc               = $data['category_id'] ?? NULL;
            $product->save();


            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Error updating Product with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();

        try {
            $Product = $this->find($id);

            if (!$Product) {
                throw new \Exception("Product with ID {$id} not found.");
            }

            $result = $Product->delete();
            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error("Error deleting Product with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}
