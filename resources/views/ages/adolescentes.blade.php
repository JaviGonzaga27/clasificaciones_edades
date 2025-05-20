@extends('layouts.age_layout')

@section('title', 'Portal para Adolescentes')

@section('header')
    Portal de Salud para {{ $classification }}
@endsection

@section('content')
    <div class="text-center">
        <h4>Bienvenido al portal de salud para {{ $classification }}</h4>
        <p>Rango de edad: {{ $range }}</p>

        <div class="mt-4">
            <p>Aquí encontrarás información relevante sobre la salud de adolescentes,
                incluyendo consejos sobre nutrición, salud mental y prevención de enfermedades.</p>
        </div>
    </div>
@endsection
