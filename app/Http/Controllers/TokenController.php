<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Services\TokenService;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function createToken(Request $request, TokenService $token_service)
    {
        $admin = AdminModel::find($request->username);
        $token = $token_service->createToken($admin);
        return response()->json([
            'token'                         => $token
        ], 200);
    }

    public function validateToken()
    {
        return response()->json([], 204);
    }

    public function deleteAllUserTokens(Request $request, TokenService $token_service)
    {
        $admin = $request->user();
        $token_service->deleteAllUserTokens($admin);
        return response()->json([], 204);
    }
}
