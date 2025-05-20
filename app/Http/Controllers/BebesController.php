<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BebesController extends Controller
{
    public function index()
    {
        return view('ages.bebes', [
            'classification' => 'Bebes',
            'range' => '0 - 5 años'
        ]);
    }
}
