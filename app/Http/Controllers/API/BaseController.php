<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result, $msg)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $msg
        ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMsg = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error
        ];
        if (!empty($errorMsg)) {
            $response['data'] = $errorMsg;
        }
        return response()->json($response, $code);
    }
}
