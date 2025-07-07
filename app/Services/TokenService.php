<?php

namespace App\Services;

use App\Models\AdminModel;

class TokenService
{
    public function isPwdOk($username, $pwd): bool
    {
        $admin = AdminModel::find($username);

        if (!$admin) {
            return false;
        }

        return password_verify($pwd, $admin->pwd);
    }

    public function createToken(AdminModel $admin): string
    {
        return $admin->createToken($admin->username, [])->plainTextToken;
    }
}
