<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MayoresController extends Controller
{
    public function index()
    {
        return view('ages.mayores', [
            'classification' => 'Mayores',
            'range' => '60 - 74 años'
        ]);
    }
}
