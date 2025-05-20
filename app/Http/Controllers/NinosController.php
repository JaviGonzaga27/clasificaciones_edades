<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NinosController extends Controller
{
    public function index()
    {
        return view('ages.ninos', [
            'classification' => 'Niños',
            'range' => '6 - 12 años'
        ]);
    }
}
