<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);

        return response()->json([
            'users' => User::with(['role', 'customer', 'broker'])->get(),
        ]);
    }

    public function show(Request $request, User $user)
    {
        Gate::authorize('view', $user);

        return response()->json([
            'user' => $user->load(['role', 'customer', 'broker']),
        ]);
    }
}
