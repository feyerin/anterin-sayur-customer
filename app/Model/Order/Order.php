<?php

namespace App\Model\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\OrderProduct\OrderProduct;
use App\Model\Product\Product;

class Order extends Model
{
    use SoftDeletes;
    
    const STATUS_CART = 0;
    const STATUS_CHECKOUT = 1;
    const STATUS_PENDING = 2;
    const STATUS_PAID = 3;

    public function updateCart($userId, $productId, $quantity, $orderProductId = null)
    {
        $product = Product::find($productId);

        if(empty($product)) {
            return false;
        } 

        $orderProduct = OrderProduct::updateOrderProduct($this->id, $product, $quantity, $orderProductId);

        $this->calculateTotalPrice();

        return true;
    }

    public function generateOrderCode()
    {
        $prefix = "#AS-" . rand(1000, 9999);
        $postfix = strtotime(date('d-m-Y H:i:s'));

        return "$prefix$postfix";
    }

    public function calculateTotalPrice()
    {
        $orderProducts = OrderProduct::where('orderId', $this->id)->get();

        $this->totalQuantity = 0;
        $this->totalPrice = 0;
        $this->totalPayment = 0;
        $this->totalDiscount = 0;

        foreach($orderProducts as $orderProduct)
        {
            $this->totalQuantity = $this->totalQuantity + $orderProduct->quantity;
            $this->totalPrice = $this->totalPrice + $orderProduct->totalPrice;
            $this->totalPayment = $this->totalPayment + $orderProduct->totalDiscount;
            $this->totalDiscount = $this->totalDiscount + $orderProduct->totalDiscountPrice;
        }

        $this->save();
    }

    public static function checkout($userId)
    {
        $order = self::where('userId', $userId)->where('status', self::STATUS_CART)->first();

        $saveToCheckout = $order->checkCheckout();
        if($saveToCheckout){
            $order->status = self::STATUS_CHECKOUT;
            $order->save();
        }
        $result['status'] = $saveToCheckout;
        $result['orderId'] = $order->id;

        return $result;
    }

    public function checkCheckout()
    {
        $orderProducts = OrderProduct::where('orderId', $this->id)->get();

        foreach($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->productId);

            if(empty($product) || $orderProduct->quantity > $product->quantity) {
                return false;
            }  
        }

        foreach($orderProducts as $orderProduct) {
            $product = Product::find($orderProduct->productId);

            $product->quantity -= $orderProduct->quantity;

            $product->save();
        }

        return true;
    }
}
