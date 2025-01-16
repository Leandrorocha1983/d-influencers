<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->routes(function () {
            Route::prefix('api') // Define o prefixo para rotas de API
                ->middleware('api') // Middleware para API
                ->group(base_path('routes/api.php')); // Define o arquivo de rotas de API

            Route::middleware('web') // Middleware para rotas web
                ->group(base_path('routes/web.php')); // Define o arquivo de rotas web
        });
    }
}


