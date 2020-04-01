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

        return $this->getResponse($banners);
    }

    public function read($id)
    {
        $banner = Banner::find($id);

        if (empty($banner)) {
            return $this->throwError(404);
        }

        return $this->getResponse($banner);
    }
}
