<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JovenesController extends Controller
{
    public function index()
    {
        return view('ages.jovenes', [
            'classification' => 'Jóvenes adultos',
            'range' => '18 - 25 años'
        ]);
    }
}
