<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_department","view_any_department","create_department","update_department","restore_department","restore_any_department","replicate_department","reorder_department","delete_department","delete_any_department","force_delete_department","force_delete_any_department","view_meeting","view_any_meeting","create_meeting","update_meeting","restore_meeting","restore_any_meeting","replicate_meeting","reorder_meeting","delete_meeting","delete_any_meeting","force_delete_meeting","force_delete_any_meeting","view_region","view_any_region","create_region","update_region","restore_region","restore_any_region","replicate_region","reorder_region","delete_region","delete_any_region","force_delete_region","force_delete_any_region","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_vendor","view_any_vendor","create_vendor","update_vendor","restore_vendor","restore_any_vendor","replicate_vendor","reorder_vendor","delete_vendor","delete_any_vendor","force_delete_vendor","force_delete_any_vendor","widget_CalendatWidget"]}]';
        $directPermissions = '{"42":{"name":"view_user","guard_name":"web"},"43":{"name":"view_any_user","guard_name":"web"},"44":{"name":"create_user","guard_name":"web"},"45":{"name":"update_user","guard_name":"web"},"46":{"name":"restore_user","guard_name":"web"},"47":{"name":"restore_any_user","guard_name":"web"},"48":{"name":"replicate_user","guard_name":"web"},"49":{"name":"reorder_user","guard_name":"web"},"50":{"name":"delete_user","guard_name":"web"},"51":{"name":"delete_any_user","guard_name":"web"},"52":{"name":"force_delete_user","guard_name":"web"},"53":{"name":"force_delete_any_user","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
