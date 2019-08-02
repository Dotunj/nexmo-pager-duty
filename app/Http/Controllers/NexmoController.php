<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NexmoController extends Controller
{
    public function status(Request $request)
    {
        Log::info($request->all());
    }

    public function inbound(Request $request)
    {
        Log::info($request->all());
    }
}
