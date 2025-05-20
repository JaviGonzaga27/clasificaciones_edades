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
        $correctRouteName = $this->ageRouterService->getRouteNameByAge($age);

        // Si la ruta actual no coincide con la que corresponde a su edad
        if (!$request->routeIs($correctRouteName)) {
            // Aquí está el cambio: Redirigir al formulario de edad con un mensaje explicativo
            return redirect()->route('age.form')
                ->with('error', 'No tienes la edad adecuada para acceder a esa sección. Por favor, ingresa tu edad nuevamente o accede a la sección que corresponde a tu edad.');
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

            // Obtener el nombre de la ruta correspondiente
            $targetRouteName = $this->ageRouterService->getRouteNameByAge($age);

            // Redirigir a la ruta correspondiente
            return redirect()->route($targetRouteName);
        } catch (\Exception $e) {
            \Log::error('Error en middleware AgeValidator', ['error' => $e->getMessage()]);
            return redirect()->route('age.form')
                ->withErrors(['error' => 'Ha ocurrido un error. Por favor, intenta de nuevo.']);
        }
    }
}
