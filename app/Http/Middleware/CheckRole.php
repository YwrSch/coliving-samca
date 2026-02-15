<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    // Adicione $role como argumento
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Se o usuário não tiver o 'role' exigido pela rota
        if ($request->user()->role !== $role) {
            // Redireciona de volta para o dashboard principal (que o redirecionará novamente)
            return redirect('/dashboard');
        }
        return $next($request);
    }
}