<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\User;
//use Laravel\Pail\ValueObjects\Origin\Http;
use Illuminate\Support\Facades\Http;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
      
    public function boot(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            $response = Http::post('http://127.0.0.1:8000/api/autenticacion', [
                'email' => $request->email,
                'password' => $request->password,
            ]);
    
            if ($response->successful()) {
                $userData = $response->json(); // Supone que la API devuelve los datos del usuario
    
                $user = User::updateOrCreate(
                    ['email' => $userData['email']],
                    [
                        'name' => $userData['name'],
                        'password' => bcrypt($request->password), // No es necesario guardar el password si solo usas API
                    ]
                );
    
                return $user;
            }
    
            return null; // Si la API rechaza el login, Laravel no autenticará al usuario
        });
    }
    
}
