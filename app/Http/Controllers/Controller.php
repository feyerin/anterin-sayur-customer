<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Symfony\Component\HttpFoundation\Response as SResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function throwError($code, $message = 'Error')
    {
        $result = json_decode("{}");
        // return Response::json('Not Found id = ' . $id, 404);
        $result->message = SResponse::$statusTexts[$code];
        $result->code = $code;
        $result->data = $message;
        $result->params = [];

        return response()->json($result);
    }

    public function getResponse($data, $params = [])
    {
        $result = json_decode("{}");

        $result->message = 'success';
        $result->code = 200;
        $result->data = $data;
        $result->params = $params;

        return response()->json($result);
    }
}
