<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Purchase\PurchaseResource;
use App\Http\Resources\Purchase\PurchaseResourceCollection;
use App\Repositories\Contracts\PurchaseRepositoryInterface;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function getAllPurchase(array $filterData)
    {

        try {

            $purchases = Purchase::with(['purchaseDetails', 'supplier']);

            if (!empty($filterData['supplier_id'])) {
                $purchases = $purchases->where('supplier_id',$filterData['supplier_id']);
            }

            if (!empty($filterData['from_date']) && !empty($filterData['to_date'])) {
                $purchases = $purchases->whereBetween('purchase_date',[$filterData['from_date'],$filterData['to_date']]);
            }

            return new PurchaseResourceCollection($purchases->paginate(10));

        } catch (\Exception $e) {

            logger()->error('Error fetching Purchases: ' . $e->getMessage());
            throw $e;
        }
    }

    public function find(int $id)
    {
        try {
            return new PurchaseResource(Purchase::with('purchaseDetails','supplier')->find($id));
        } catch (\Exception $e) {
            logger()->error("Error finding Purchase with ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function create(array $data)
    {

        DB::beginTransaction();

        try {
            $Purchase                            = new Purchase;
            $Purchase->supplier_id               = $data['supplier_id'];
            $Purchase->purchase_date             = $data['purchase_date'];
            $Purchase->total_amount              = 0;
            $Purchase->save();



            //Fetch product for current stock update. And Default price (if not price is set on purchase)
            $products = Product::whereIn('id', $data['product_id'])->get();

            $productDefaultPriceArr = [];
            $productCurrentStockArr = [];

            if ($products->isNotEmpty()) {
                foreach ($products as $product) {
                    $productDefaultPriceArr[$product->id] = $product->price;
                    $productCurrentStockArr[$product->id] = $product->current_stock_quantity;
                }
            }

            $itemsArr = [];
            $currentStockUpdateArr = [];
            $totalPrice = 0;
            if (!empty($data['product_id'])) {
                $i = 0;
                foreach ($data['product_id'] as $productId) {
                    $itemsArr[$i]['purchase_id']            = $Purchase->id;
                    $itemsArr[$i]['product_id']             = $productId;
                    $itemsArr[$i]['quantity']               = $data['quantity'][$productId] ?? 0;
                    $itemsArr[$i]['unit_price']             = $data['unit_price'][$productId] ?? $productDefaultPriceArr[$productId];
                    $itemsArr[$i]['total_price']            = (($data['unit_price'][$productId] ?? $productDefaultPriceArr[$productId]) * $data['quantity'][$productId]) ?? 0;

                    //Calculate total price
                    $totalPrice                             = $totalPrice + $itemsArr[$i]['total_price'];

                    //Current stock update arr created
                    $currentStockUpdateArr[$i]['id']                       = $productId;
                    $currentStockUpdateArr[$i]['current_stock_quantity']   = $productCurrentStockArr[$productId] + $data['quantity'][$productId];
                    $i++;
                }
            }

            PurchaseItem::insert($itemsArr);
            Product::batchUpdate($currentStockUpdateArr, ['current_stock_quantity']);
            $Purchase->update(['total_amount' => $totalPrice]);

            DB::commit();
            return $Purchase;
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error creating Purchase: ' . $e->getMessage());
            throw $e;
        }
    }
}
