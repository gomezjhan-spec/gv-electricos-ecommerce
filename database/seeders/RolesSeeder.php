<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'mayorista']);
        Role::firstOrCreate(['name' => 'cliente']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@gvelectricos.com'],
            [
                'name'     => 'Administrador GV',
                'password' => bcrypt('admin123456'),
            ]
        );
        $admin->syncRoles(['admin']);

        $this->command->info('✅ Roles creados correctamente');
        $this->command->info('📧 Email: admin@gvelectricos.com');
        $this->command->info('🔑 Password: admin123456');
    }
}