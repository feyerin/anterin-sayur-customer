<?php

namespace App\Model\OrderProduct;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Product\Product;

class OrderProduct extends Model
{
    use SoftDeletes;

    public static function updateOrderProduct($orderId, $product, $quantity, $orderProductId)
    {
        if(!empty($orderProductId)) {
            $orderProduct = self::find($orderProductId);
        } else {
            $orderProduct = new self;

            $orderProduct->orderId = $orderId;
            $orderProduct->productId = $product->id;
            $orderProduct->price = $product->price;
        }

        if($quantity == 0) {
            $orderProduct->forceDelete();
        } else {
            $orderProduct->quantity = $quantity;
            $orderProduct->totalPrice = $product->price * $quantity;
            $orderProduct->totalDiscount = $product->totalDiscount * $quantity;
            $orderProduct->totalDiscountPrice = $product->discountPrice * $quantity;
    
            $orderProduct->save();
        }
    }
}
