<?php

namespace App\Services;

use App\Models\AdminModel;

class DefaultAdminService
{
    private function isEnvironmentReady(): bool
    {
        $admin_username = env('ADMIN_USERNAME', null);
        $admin_pwd = env('ADMIN_PWD', null);

        return $admin_username != null && $admin_pwd != null;
    }

    public function isDefaultAdminLoaded(): bool
    {
        if (!$this->isEnvironmentReady()) {
            throw new \Exception("No default username or password set in .env file");
        }

        $admin_username = env('ADMIN_USERNAME', null);

        return AdminModel::where('username', $admin_username)->exists();
    }

    public function loadDefaultAdmin(): void
    {
        if (!$this->isEnvironmentReady()) {
            throw new \Exception("No default username or password set in .env file");
        }

        if ($this->isDefaultAdminLoaded()) {
            throw new \Exception("Default admin has already been loaded");
        }

        $admin_username = env('ADMIN_USERNAME', null);
        $admin_pwd = env('ADMIN_PWD', null);

        $admin = new AdminModel;
        $admin->username = $admin_username;
        $admin->pwd = password_hash($admin_pwd, PASSWORD_DEFAULT);
        $admin->save();
    }
}
