<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_super_admin = Role::create(['name' => 'super-admin']);

        // Pages
        $permission_pages_delete = Permission::create(['name' => 'delete pages']);
        $permission_pages_create = Permission::create(['name' => 'create pages']);
        $permission_pages_edit = Permission::create(['name' => 'edit pages']);
        $permission_pages_show = Permission::create(['name' => 'show pages']);

        // Menus
        $permission_menus_delete = Permission::create(['name' => 'delete menus']);
        $permission_menus_create = Permission::create(['name' => 'create menus']);
        $permission_menus_edit = Permission::create(['name' => 'edit menus']);
        $permission_menus_show = Permission::create(['name' => 'show menus']);

        // Collections
        $permission_collections_delete = Permission::create(['name' => 'delete collections']);
        $permission_collections_create = Permission::create(['name' => 'create collections']);
        $permission_collections_edit = Permission::create(['name' => 'edit collections']);
        $permission_collections_show = Permission::create(['name' => 'show collections']);

        // Blocks
        $permission_blocks_delete = Permission::create(['name' => 'delete blocks']);
        $permission_blocks_create = Permission::create(['name' => 'create blocks']);
        $permission_blocks_edit = Permission::create(['name' => 'edit blocks']);
        $permission_blocks_show = Permission::create(['name' => 'show blocks']);

        // User
        $permission_users_delete = Permission::create(['name' => 'delete users']);
        $permission_users_create = Permission::create(['name' => 'create users']);
        $permission_users_edit = Permission::create(['name' => 'edit users']);
        $permission_users_show = Permission::create(['name' => 'show users']);

        // Medias
        $permission_medias_delete = Permission::create(['name' => 'delete medias']);
        $permission_medias_create = Permission::create(['name' => 'create medias']);
        $permission_medias_edit = Permission::create(['name' => 'edit medias']);
        $permission_medias_show = Permission::create(['name' => 'show medias']);

        $permission_super_admin =
            [
                $permission_pages_delete,
                $permission_pages_create,
                $permission_pages_show,
                $permission_menus_delete,
                $permission_menus_create,
                $permission_menus_edit,
                $permission_menus_show,
                $permission_collections_delete,
                $permission_collections_create,
                $permission_collections_edit,
                $permission_collections_show,
                $permission_blocks_delete,
                $permission_blocks_create,
                $permission_blocks_edit,
                $permission_blocks_show,
                $permission_pages_edit,
                $permission_users_delete,
                $permission_users_create,
                $permission_users_edit,
                $permission_users_show,
                $permission_medias_delete,
                $permission_medias_create,
                $permission_medias_edit,
                $permission_medias_show,
            ];

        $role_super_admin->syncPermissions($permission_super_admin);
    }
}
