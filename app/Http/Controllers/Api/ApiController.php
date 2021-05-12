<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function apiResponse($resultType, $data, $message = null, $code = 200)
    {
        $response = [];
        $response['success'] = ($resultType == ResultTypeController::Success) ? true : false;

        if (isset($data)){
            if ($resultType != ResultTypeController::Error){
                $response['data'] = $data;
            }

            if ($resultType == ResultTypeController::Error){
                $response['errors'] = $data;
            }
        }

        if (isset($message)){
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}
