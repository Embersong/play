<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAddedException extends \Exception
{
    public function render(Request $request):JsonResponse
    {
        return response()->json([
            'success' => 'false',
            'error' => 'You already added on this match.'
        ], 400);
    }
}
