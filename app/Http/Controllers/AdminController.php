<?php

namespace App\Http\Controllers;

use App\Services\DefaultAdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function loadDefaultAdmin(DefaultAdminService $default_admin_service)
    {
        $default_admin_service->loadDefaultAdmin();
        return response()->json(['message' => 'Default admin has been loaded successfully'], 200);
    }
}
