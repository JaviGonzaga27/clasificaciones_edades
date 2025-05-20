<?php

namespace App\Http\Middleware;

use App\Models\AgeLog;
use App\Services\AgeRouterService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeValidator
{
    protected AgeRouterService $ageRouterService;
    
    public function __construct(AgeRouterService $ageRouterService)
    {
        $this->ageRouterService = $ageRouterService;
    }
    
    public function handle(Request $request, Closure $next): Response
    {
        // Si es la ruta de procesamiento del formulario
        if ($request->route()->getName() === 'age.process') {
            return $this->processAgeForm($request);
        }
        
        // Si es la ruta de olvidar la edad
        if ($request->route()->getName() === 'age.forget') {
            session()->forget('validated_age');
            return redirect()->route('age.form');
        }
        
        // Para cualquier otra ruta, verificar si existe la sesión de edad
        if (!session()->has('validated_age')) {
            return redirect()->route('age.form')
                ->with('error', 'Por favor, ingresa tu edad para acceder a esta sección.');
        }
        
        // Verificar si la ruta actual coincide con la categoría de edad
        $age = session('validated_age');
        $correctRoute = $this->ageRouterService->getRouteByAge($age);
        $currentPath = '/' . $request->path();
        
        // Si la ruta actual no coincide con la que corresponde a su edad
        if ($currentPath !== $correctRoute) {
            return redirect($correctRoute);
        }
        
        return $next($request);
    }
    
    /**
     * Procesa el formulario de edad
     */
    protected function processAgeForm(Request $request): Response
    {
        // Validar que la edad esté presente y sea numérica
        if (!$request->has('age') || !is_numeric($request->age)) {
            return redirect()->route('age.form')
                ->withErrors(['age' => 'La edad debe ser un número válido']);
        }
        
        $age = (int) $request->age;
        
        // Validar que la edad esté dentro del rango permitido
        if (!$this->ageRouterService->isValidAge($age)) {
            return redirect()->route('age.form')
                ->withErrors(['age' => 'La edad debe estar entre 0 y 120 años']);
        }
        
        try {
            // Registrar la edad en la base de datos
            AgeLog::create([
                'age' => $age,
                'ip_address' => $request->ip()
            ]);
            
            // Guardar la edad validada en la sesión
            session(['validated_age' => $age]);
            
            // Obtener la ruta correspondiente
            $targetRoute = $this->ageRouterService->getRouteByAge($age);
            
            // Redirigir a la ruta correspondiente
            return redirect($targetRoute);
        } catch (\Exception $e) {
            \Log::error('Error en middleware AgeValidator', ['error' => $e->getMessage()]);
            return redirect()->route('age.form')
                ->withErrors(['error' => 'Ha ocurrido un error. Por favor, intenta de nuevo.']);
        }
    }
}