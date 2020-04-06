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

        $productArray = $products->toArray();

        $result = array_map(function ($row) {
            $mapResult = $row;
            $mapResult['imageurl'] = 'https://s3.' . env('AWS_S3_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $row['image'];

            return $mapResult;
        }, $productArray);

        // return Response::make($products, 200);
        return $this->getResponse($result);
    }

    public function read($id)
    {
        $product = Product::find($id);

        if (empty($product)) {
            return $this->throwError(404);
        }

        $result = $product->toArray();
        $result['imageUrl'] = 'https://s3.' . env('AWS_S3_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $product['image'];

        // return Response::make($product, 200);
        return $this->getResponse($result);
    }
}
