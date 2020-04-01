<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Product\Product;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at')->get();

        // return Response::make($products, 200);
        return $this->getResponse($products);
    }

    public function read($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return $this->throwError(404);
        }

        // return Response::make($product, 200);
        return $this->getResponse($product);
    }
}
