<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function echo() {
        return response()->json( ['result'=>'echo']);
    }
}

