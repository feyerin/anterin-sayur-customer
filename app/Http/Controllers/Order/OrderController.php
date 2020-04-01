<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order\Order;
use App\Model\OrderProduct\OrderProduct;
use App\Model\Product\Product;
use Illuminate\Support\Facades\Auth;
use App\Mailer;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        
        return $this->getResponse($orders);
    }

    public function getOrderByUser(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)) {
            $userId = $user->id;
        } else {
            $userId = $request->session()->get('tempUserId');
            if(empty($userId)) {
                $userId = -(strtotime(date('d-m-Y H:i:s')));
                $request->session()->put('tempUserId', $userId);
            }
        }

        $orders = Order::where('userId', $userId)->get();
        
        return $this->getResponse($orders);
    }

    public function read($id)
    {
        $order['order'] = Order::find($id);
        $orderProduct = OrderProduct::where('orderId', $id)->get();
        $orderProductArray = $orderProduct->toArray();

        if (empty($order['order']) || $order['order'] == null) {
            return $this->throwError(404);
        }

        $order['orderProduct'] = array_map(function ($row) {
            $product = Product::find($row['productId']);

            $result = $row;
            if(!empty($product)) {
                $result['productName'] = $product->name;
                $result['productImage'] = $product->image;
            } else {
                $result['productName'] = '';
                $result['productImage'] = '';
            }

            return $result;
        }, $orderProductArray);

        return $this->getResponse($order, $orderProduct);
    }

    public function getOrderProduct($id)
    {
        $orderProducts = OrderProduct::where('orderId', $id)->get();

        if (empty($orderProducts)) {
            return $this->throwError(404);
        }

        return $this->getResponse($orderProducts, [
            'orderId' => $id
        ]);
    }

    public function getCart(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)) {
            $userId = $user->id;
        } else {
            $userId = $request->session()->get('tempUserId');
            if(empty($userId)) {
                $userId = -(strtotime(date('d-m-Y H:i:s')));
                $request->session()->put('tempUserId', $userId);
            }
        }

        $order['order'] = Order::where('userId', $userId)->where('status', Order::STATUS_CART)->first();
        if (empty($order['order']) || $order['order'] == null) {
            return $this->throwError(404);
        }
        $orderProduct = OrderProduct::where('orderId', $order['order']->id)->get();
        $orderProductArray = $orderProduct->toArray();

        $order['orderProduct'] = array_map(function ($row) {
            $product = Product::find($row['productId']);

            $result = $row;
            if(!empty($product)) {
                $result['productName'] = $product->name;
                $result['productImage'] = $product->image;
            } else {
                $result['productName'] = '';
                $result['productImage'] = '';
            }

            return $result;
        }, $orderProductArray);

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)) {
            $userId = $user->id;
        } else {
            $userId = $request->session()->get('tempUserId');
            if(empty($userId)) {
                $userId = -(strtotime(date('d-m-Y H:i:s')));
                $request->session()->put('tempUserId', $userId);
            }
        }

        $orderProductId = null;
        $order = Order::where('userId', $userId)->where('status', Order::STATUS_CART)->first();

        if(empty($order)) {
            $order = new Order;

            $order->userId = $userId;
            $order->orderCode = $order->generateOrderCode();
            $order->status = 0;

            $order->save();
        }

        $quantity = $request->input('quantity');
        $orderProduct = OrderProduct::where('orderId', $order->id)->where('productId', $request->input('productId'))->first();
        if (!empty($orderProduct)) {
            $orderProductId = $orderProduct->id;
            $quantity = $quantity + $orderProduct->quantity;
        }

        if(!$order->updateCart($userId, $request->input('productId'), $quantity, $orderProductId)) {
            return $this->getResponse(404, "productId : " . $request->input('productId'));
        }

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function updateCart(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)) {
            $userId = $user->id;
        } else {
            $userId = $request->session()->get('tempUserId');
            if(empty($userId)) {
                $userId = -(strtotime(date('d-m-Y H:i:s')));
                $request->session()->put('tempUserId', $userId);
            }
        }

        $order = Order::where('userId', $userId)->where('status', Order::STATUS_CART)->first();

        foreach($request->input('orderProduct') as $orderProduct) {
            $order->updateCart($userId, $orderProduct['productId'], $orderProduct['quantity'], $orderProduct['id']);
        }

        return $this->getResponse($order, [
            'userId' => $userId
        ]);
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)) {
            $userId = $user->id;
        } else {
            $userId = $request->session()->get('tempUserId');
            if(empty($userId)) {
                $userId = -(strtotime(date('d-m-Y H:i:s')));
                $request->session()->put('tempUserId', $userId);
            }
        }

        $checkout = Order::checkout($userId);

        return $this->getResponse($checkout['status'], [
            'userId' => $userId,
            'orderId' => $checkout['orderId']
        ]);
    }

    public function setUserData(Request $request)
    {
        $user = Auth::user();
        if(!empty($user)) {
            $userId = $user->id;
        } else {
            $userId = $request->session()->get('tempUserId');
            if(empty($userId)) {
                $userId = -(strtotime(date('d-m-Y H:i:s')));
                $request->session()->put('tempUserId', $userId);
            }
        }

        $order = Order::where('userId', $userId)->where('id', $request->input('orderId'))->first();
        
        $order->name = $request->input('name');
        $order->address = $request->input('address');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        $order->status = Order::STATUS_PENDING;

        $order->save();

        $mail = Mailer::sendEmail($order, $order->email);

        return $this->getResponse('tes', [
            'userMail' => $user->email,
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'orderId' => $request->input('orderId'),
            'mail' => $mail
        ]);
    }

    public function setPaidOrder(Request $request)
    {
        $order = Order::find($request->input('orderId'));
        
        $order->status = Order::STATUS_PAID;
        $order->paymentDate = date("Y-m-d H:i:s");

        $order->save();

        return $this->getResponse($order, 
            $request->input()
        );
    }

    public function checkSession(Request $request) {
        return $this->getResponse(Auth::user());
    }
}
