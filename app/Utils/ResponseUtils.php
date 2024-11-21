<?php

namespace App\Utils;

class ResponseUtils
{
    public static function errorResponse($message, $statusCode, $error = "")
    {
        return [
            'message' => $message,
            'statusCode' => $statusCode,
            'status' => 'error',
            'error' => $error
        ];
    }
    public static function errorResponseNotFound($message, $statusCode, $error = "")
    {
        return [
            'message' => $message,
            'statusCode' => $statusCode,
            'status' => 'Not Found',
            'error' => $error
        ];
    }

    public static function successResponse($message, $statusCode)
    {
        return [
            'message' => $message,
            'statusCode' => $statusCode,
            'status' => 'success'
        ];
    }

    public static function successResponseData($data, $message, $statusCode)
    {
        return [
            'data' => $data,
            'message' => $message,
            'statusCode' => $statusCode,
            'status' => 'success'
        ];
    }
    public static function successResponseDataWTotal($total = 0, $data = "", $message, $statusCode)
    {
        return [
            'total' => $total,
            'data' => $data,
            'message' => $message,
            'statusCode' => $statusCode,
            'status' => 'success'
        ];
    }
}
