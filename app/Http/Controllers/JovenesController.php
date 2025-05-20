<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JovenesController extends Controller
{
    public function index()
    {
        return view('ages.jovenes', [
            'classification' => 'Jóvenes',
            'range' => '6 - 11 años'
        ]);
    }
}
