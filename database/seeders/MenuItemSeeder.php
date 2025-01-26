<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuItem::factory()->count(10)->create();
        MenuItem::insert(
            [
                [
                    'name' => 'Dashboard',
                    'route' => 'dashboard',
                    'permission_name' => 'dashboard',
                    'menu_group_id' => 1,
                ],
                [
                    'name' => 'Universitas',
                    'route' => 'master-management/universitas',
                    'permission_name' => 'universitas.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Fakultas',
                    'route' => 'master-management/fakultas',
                    'permission_name' => 'fakultas.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Jurusan/Program',
                    'route' => 'master-management/jurusan-program',
                    'permission_name' => 'jurusan-program.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Program Studi',
                    'route' => 'master-management/program-studi',
                    'permission_name' => 'program-studi.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Gedung',
                    'route' => 'master-management/gedung',
                    'permission_name' => 'gedung.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Ruang',
                    'route' => 'master-management/ruang',
                    'permission_name' => 'ruang.index',
                    'menu_group_id' => 2,
                ],
                [
                    'name' => 'Organisasi Internal',
                    'route' => 'organization-management/internal-organisasi',
                    'permission_name' => 'internal-organisasi.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Organisasi Eksternal',
                    'route' => 'organization-management/eksternal-organisasi',
                    'permission_name' => 'eksternal-organisasi.index',
                    'menu_group_id' => 3,
                ],
                [
                    'name' => 'Dosen List',
                    'route' => 'user-management/dosen',
                    'permission_name' => 'dosen.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Mahasiswa List',
                    'route' => 'user-management/mahasiswa',
                    'permission_name' => 'mahasiswa.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Admin List',
                    'route' => 'user-management/admin',
                    'permission_name' => 'admin.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Pengguna Luar List',
                    'route' => 'user-management/pengguna-luar',
                    'permission_name' => 'pengguna-luar.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'User List',
                    'route' => 'user-management/user',
                    'permission_name' => 'user.index',
                    'menu_group_id' => 4,
                ],
                [
                    'name' => 'Role List',
                    'route' => 'role-and-permission/role',
                    'permission_name' => 'role.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Permission List',
                    'route' => 'role-and-permission/permission',
                    'permission_name' => 'permission.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Permission To Role',
                    'route' => 'role-and-permission/assign',
                    'permission_name' => 'assign.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'User To Role',
                    'route' => 'role-and-permission/assign-user',
                    'permission_name' => 'assign.user.index',
                    'menu_group_id' => 5,
                ],
                [
                    'name' => 'Menu Group',
                    'route' => 'menu-management/menu-group',
                    'permission_name' => 'menu-group.index',
                    'menu_group_id' => 6,
                ],
                [
                    'name' => 'Menu Item',
                    'route' => 'menu-management/menu-item',
                    'permission_name' => 'menu-item.index',
                    'menu_group_id' => 6,
                ],
            ]
        );
    }
}
