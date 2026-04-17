<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function show(User $user): JsonResponse
    {
        $user->load('services', 'favouriteServices');

        return response()->json([
            'user' => $user,
        ], 200);
    }

    public function favourites(User $user): JsonResponse
    {
        $favourites = $user->favouriteServices()->with('user')->latest()->get();

        return response()->json([
            'favourites' => $favourites,
        ], 200);
    }
}