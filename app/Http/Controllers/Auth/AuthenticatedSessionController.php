<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    // Mostrar formulario de login
    public function create(): View
    {
        return view('auth.login');
    }

    // Procesar login
 public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt(
        $request->only('email', 'password'),
        $request->boolean('remember')
    )) {
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    $user = Auth::user();

    // Si es admin
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    // Usuario normal
    return redirect('/');

// Redirigir según rol
$user = Auth::user();

if ($user->hasRole('admin')) {
    return redirect(url('/admin/dashboard'));
}

return redirect(url('/'));

}
    // Cerrar sesión
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}