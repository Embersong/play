<?php

namespace App\Exceptions;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatchFullException extends \Exception
{

    public function render(Request $request):JsonResponse
    {
        return response()->json([
            'success' => 'false',
            'error' => 'Match is full.'
        ], 400);
    }
}
