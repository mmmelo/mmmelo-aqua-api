<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function __construct() {

    }
    public function echo() {
        return $this->successResponse( ['echo'=>'echo']);
    }

    public function echoAuth() {
        return $this->successResponse(  ['echo' => 'auth']);
    }
}
