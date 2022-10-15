<?php
namespace App\Traits;

/**
 * This is a trait that contains all the methods that are used to return api responses
 */
trait HttpResponses{
    /**
     * This method is used to return a success response
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, $message = "Thanks for using our service", $code = 200)
    {
        return response()->json([
            "status" => "success",
            "message" => $message,
            "data" => $data
        ], $code);
    }
    /**
     * This method is used to return a error response
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($data, $message = "server error", $code = 500)
    {
        return response()->json([
            "status" => "error",
            "message" => $message,
            "data" => $data
        ], $code);
    }
}