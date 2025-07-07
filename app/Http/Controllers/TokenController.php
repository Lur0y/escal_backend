<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Services\TokenService;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function createToken(Request $request)
    {
        $token_service = new TokenService;
        $admin = AdminModel::find($request->username);
        $token = $token_service->createToken($admin);
        return response()->json([
            'token'                         => $token
        ], 200);
    }
}
