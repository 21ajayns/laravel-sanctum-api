<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ApiHeaderController extends Controller
{
    public function checkHealth(Request $request):Response 
    {
        $header = $request->header();
        return new Response($header);
        //return new Response("access granted");
    }
}
