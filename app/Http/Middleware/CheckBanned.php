<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class CheckBanned
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND is banned
        if (Auth::check() && Auth::user()->banned_at) {
            
            Auth::logout(); // Déconnexion automatique

            // Invalidation de la session pour plus de sécurité
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->with('error', 'Votre compte a été banni par un administrateur.'); // Message d'erreur
        }

        return $next($request);
    }
}