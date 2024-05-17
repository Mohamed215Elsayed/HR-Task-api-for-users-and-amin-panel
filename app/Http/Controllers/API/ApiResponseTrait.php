<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\JsonResponse;
trait ApiResponseTrait
{
    //
    public function apiResponse($data = null, $message = null, $status = null){
        $array = [
            'data' => $data,
            'message'=>$message,
            'status' => $status
        ];
        return response($array,JsonResponse::HTTP_OK);
    }
}
