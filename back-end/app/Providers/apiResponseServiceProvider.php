<?php

namespace App\Providers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class apiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Response::macro('success', function (string $message, array | Arrayable $data, int $status = 200) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ], $status);
        });

        response::macro('error', function (string $message, string $error = '', int $status = 500) {
            if (env('APP_DEBUG')) {
                $message = $message . ' - ' . $error;
            }

            return response()->json([
                'success' => false,
                'error' => $message,
            ], $status);
        });
    }
}
