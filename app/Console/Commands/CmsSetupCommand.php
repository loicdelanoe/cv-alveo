<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CmsSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up roles, permissions, and the super admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (! (Schema::hasTable('users') && Schema::hasTable('permissions') && Schema::hasTable('roles'))) {
            $this->error('Required tables are missing. Please ensure the migration has been run.');

            return;
        }

        // --- Create roles and permissions if not present
        if (! Role::where('name', 'super-admin')->exists()) {
            $this->info('Creating super-admin role and permissions...');

            $role = Role::create(['name' => 'super-admin']);

            $permissions = [
                // Pages
                'delete pages', 'create pages', 'edit pages', 'show pages',
                // Menus
                'delete menus', 'create menus', 'edit menus', 'show menus',
                // Collections
                'delete collections', 'create collections', 'edit collections', 'show collections',
                // Blocks
                'delete blocks', 'create blocks', 'edit blocks', 'show blocks',
                // Users
                'delete users', 'create users', 'edit users', 'show users',
                // Medias
                'delete medias', 'create medias', 'edit medias', 'show medias',
            ];

            $created = collect($permissions)->map(fn ($name) => Permission::create(['name' => $name]));
            $role->syncPermissions($created);
        }

        // --- Create the super-admin user if not exists
        if (! User::where('email', env('SUPER_ADMIN_EMAIL', 'admin@example.com'))->exists()) {
            $this->info('Creating super admin user...');

            $admin = User::create([
                'name' => 'Super Admin',
                'email' => env('SUPER_ADMIN_EMAIL', 'admin@example.com'),
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', '!azerty123')),
            ]);

            $this->info('Assigning super-admin role to the user...');

            $admin->assignRole('super-admin');
        }

        $this->info('CMS setup completed successfully!');
    }
}
