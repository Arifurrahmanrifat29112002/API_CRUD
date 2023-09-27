<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendRespons($result,$message)
    {
        $respons=[
            'success' => true,
            'data' => $result,
            'message'=> $message,
        ];
        return response()->json($respons,200);
    }

    public function sendError($error,$errorMessage = [],$code =404)
    {
        $respons = [
            'success' => false,
            'message'  => $error
        ];

        if(!empty($errorMessage))
        {
            $respons['data'] = $errorMessage;
        }
        return response()->json($respons,$code);
    }

    
}
