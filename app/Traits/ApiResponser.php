<?php

namespace App\Traits;

use App\Http\Controllers\Api\Constants;
use Illuminate\Database\QueryException;

trait ApiResponser {

    protected function successResponse( $data, $code=200){
        return response()->json( $data, $code);
    }

    protected function errorResponse( $message, $data=[], $code=500){
        return response()->json([
            'message' => $message,
            'error' => $data,
        ],$code);
    }

    protected function queryError( QueryException $e) {
        try {
            $message = Constants::$statusSqlTexts[$e->getCode()];
        } catch (\Exception $ex) {
            $message = $e->getMessage();
        }
        return response()->json( [
            'message' => $message,
            'data' => $e->getCode()
        ], 409);
    }
}