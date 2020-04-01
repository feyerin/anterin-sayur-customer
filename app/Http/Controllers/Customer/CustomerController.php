<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function indexCustomer()
    {
        return view("app.customer.index");
    }

    public function readProduct()
    {
        return view("app.customer.detail");
    }

    public function cart()
    {
        return view("app.customer.cart");
    }

    public function checkout()
    {
        return view("app.customer.checkout");
    }

    public function confirmation()
    {
        return view("app.customer.confirmation");
    }
}
