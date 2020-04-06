<?php

namespace App\Http\Controllers\Banner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Banner\Banner;

class BannerController extends Controller
{
    //
    public function index()
    {
        $banners = Banner::orderBy('id')->get();

        $bannerArray = $banners->toArray();

        $result = array_map(function ($row) {
            $mapResult = $row;
            $mapResult['imageurl'] = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $row['image'];

            return $mapResult;
        }, $bannerArray);


        return $this->getResponse($result);
    }

    public function read($id)
    {
        $banner = Banner::find($id);

        if (empty($banner)) {
            return $this->throwError(404);
        }

        $result = $banner->toArray();
        $result['imageUrl'] = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $banner['image'];

        return $this->getResponse($result);
    }
}
