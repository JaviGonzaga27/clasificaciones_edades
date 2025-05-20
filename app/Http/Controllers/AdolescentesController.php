<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdolescentesController extends Controller
{
    public function index()
    {
        return view('ages.adolescentes', [
            'classification' => 'Adolescentes',
            'range' => '12 - 18 años'
        ]);
    }
}
