<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdultosController extends Controller
{
    public function index()
    {
        return view('ages.adultos', [
            'classification' => 'Adultos',
            'range' => '26 - 59 años'
        ]);
    }
}
