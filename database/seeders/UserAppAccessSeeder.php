<?php

namespace Database\Seeders;

use App\Models\UserAppAccess;
use Illuminate\Database\Seeder;

class UserAppAccessSeeder extends Seeder
{
    public function run(): void
    {
        $alreadyActive = UserAppAccess::where('username', 'usuario01')
            ->where('application_code', UserAppAccess::APPLICATION_GESTION_ROLES)
            ->where('role', 'admin')
            ->where('active', true)
            ->exists();

        if ($alreadyActive) {
            return;
        }

        UserAppAccess::where('application_code', UserAppAccess::APPLICATION_GESTION_ROLES)
            ->where('role', 'admin')
            ->where('active', true)
            ->update(['active' => false]);

        UserAppAccess::create([
            'username' => 'usuario01',
            'application_code' => UserAppAccess::APPLICATION_GESTION_ROLES,
            'role' => 'admin',
            'facultad_id' => null,
            'departamento_id' => null,
            'active' => true,
        ]);
    }
}
