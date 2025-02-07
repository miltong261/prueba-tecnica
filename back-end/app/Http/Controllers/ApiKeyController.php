<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;

class ApiKeyController extends Controller
{
    public function generate()
    {
        $apiKey = ApiKey::create(['key' => \Illuminate\Support\Str::random(32)]);

        return response()->json([
            'success' => true,
            'message' => 'API key generada exitosamente',
            'data' => ['key' => $apiKey->key]
        ]);
    }
}
