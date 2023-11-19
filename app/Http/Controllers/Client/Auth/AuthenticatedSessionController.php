<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Client\Auth\LoginClientRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Client/Auth/Login', [
            'canResetPassword' => Route::has('client.password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginClientRequest $request): RedirectResponse
    {
        $request->authenticate();
        if (Auth::guard('client')->user()->gym == null) {
            
            Auth::guard('client')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return redirect()->route('homepage')->with([
                'level' => 'danger',
                'message' => 'This user is not available to login as the gym is neither available'
            ]);
        }
        $request->session()->regenerate();

        return redirect()->intended(route('client.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('homepage');
    }
}
