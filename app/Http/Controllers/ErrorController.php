<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function index()
    {
        return view('errors.error', [
            'classification' => 'Error',
            'range' => '404 Not Found'
        ]);
    }
}
