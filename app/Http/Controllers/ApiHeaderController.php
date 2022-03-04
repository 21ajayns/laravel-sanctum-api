<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ApiHeaderController extends Controller
{
    public function checkHealth(Request $request):Response 
    {
        $Value = $request->header();
        return new Response($Value);
    }
}
