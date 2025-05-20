@extends('layouts.age_layout')

@section('title', 'Error de Edad')

@section('header')
    Error en la Edad Proporcionada
@endsection

@section('content')
    <div class="text-center">
        <div class="alert alert-danger">
            <h4>La edad proporcionada no es válida</h4>
            <p>Por favor, intenta nuevamente con una edad entre 0 y 120 años.</p>
        </div>
    </div>
@endsection