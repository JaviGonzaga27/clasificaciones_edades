<?php

namespace App\Services;

class AgeRouterService
{
    /**
     * Define las clasificaciones de edad y sus rutas correspondientes
     */
    private array $ageRanges = [
        ['min' => 0, 'max' => 5, 'route' => '/bebes'],
        ['min' => 6, 'max' => 12, 'route' => '/ninos'],
        ['min' => 13, 'max' => 17, 'route' => '/adolescentes'],
        ['min' => 18, 'max' => 25, 'route' => '/jovenes'],
        ['min' => 26, 'max' => 59, 'route' => '/adultos'],
        ['min' => 60, 'max' => 74, 'route' => '/mayores'],
        ['min' => 75, 'max' => 120, 'route' => '/longevos'],
    ];
    
    /**
     * Obtiene la ruta correspondiente según la edad proporcionada
     */
    public function getRouteByAge(int $age): string
    {
        foreach ($this->ageRanges as $range) {
            if ($age >= $range['min'] && $age <= $range['max']) {
                return $range['route'];
            }
        }
        
        return '/error';
    }
    
    /**
     * Valida si la edad está dentro del rango permitido
     */
    public function isValidAge(int $age): bool
    {
        return $age >= 0 && $age <= 120;
    }
    
    /**
     * Obtiene la clasificación según la edad
     */
    public function getClassificationByAge(int $age): ?string
    {
        $classifications = [
            [0, 5, 'Bebés'],
            [6, 12, 'Niños'],
            [13, 17, 'Adolescentes'],
            [18, 25, 'Jóvenes adultos'],
            [26, 59, 'Adultos'],
            [60, 74, 'Adultos mayores'],
            [75, 120, 'Personas longevas'],
        ];
        
        foreach ($classifications as [$min, $max, $classification]) {
            if ($age >= $min && $age <= $max) {
                return $classification;
            }
        }
        
        return null;
    }
}