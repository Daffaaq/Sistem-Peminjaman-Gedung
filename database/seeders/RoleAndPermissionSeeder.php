<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'master.management']);
        Permission::create(['name' => 'Organisazation.management']);
        Permission::create(['name' => 'user.management']);
        Permission::create(['name' => 'role.permission.management']);
        Permission::create(['name' => 'menu.management']);
        //user
        Permission::create(['name' => 'user.index']);
        Permission::create(['name' => 'user.create']);
        Permission::create(['name' => 'user.edit']);
        Permission::create(['name' => 'user.destroy']);
        Permission::create(['name' => 'user.import']);
        Permission::create(['name' => 'user.export']);

        //role
        Permission::create(['name' => 'role.index']);
        Permission::create(['name' => 'role.create']);
        Permission::create(['name' => 'role.edit']);
        Permission::create(['name' => 'role.destroy']);
        Permission::create(['name' => 'role.import']);
        Permission::create(['name' => 'role.export']);

        //permission
        Permission::create(['name' => 'permission.index']);
        Permission::create(['name' => 'permission.create']);
        Permission::create(['name' => 'permission.edit']);
        Permission::create(['name' => 'permission.destroy']);
        Permission::create(['name' => 'permission.import']);
        Permission::create(['name' => 'permission.export']);

        //assignpermission
        Permission::create(['name' => 'assign.index']);
        Permission::create(['name' => 'assign.create']);
        Permission::create(['name' => 'assign.edit']);
        Permission::create(['name' => 'assign.destroy']);

        //assingusertorole
        Permission::create(['name' => 'assign.user.index']);
        Permission::create(['name' => 'assign.user.create']);
        Permission::create(['name' => 'assign.user.edit']);

        //menu group 
        Permission::create(['name' => 'menu-group.index']);
        Permission::create(['name' => 'menu-group.create']);
        Permission::create(['name' => 'menu-group.edit']);
        Permission::create(['name' => 'menu-group.destroy']);

        //menu item 
        Permission::create(['name' => 'menu-item.index']);
        Permission::create(['name' => 'menu-item.create']);
        Permission::create(['name' => 'menu-item.edit']);
        Permission::create(['name' => 'menu-item.destroy']);

        //universitas
        Permission::create(['name' => 'universitas.index']);
        Permission::create(['name' => 'universitas.create']);
        Permission::create(['name' => 'universitas.edit']);
        Permission::create(['name' => 'universitas.destroy']);

        //fakultas
        Permission::create(['name' => 'fakultas.index']);
        Permission::create(['name' => 'fakultas.create']);
        Permission::create(['name' => 'fakultas.edit']);
        Permission::create(['name' => 'fakultas.destroy']);

        //jurusan-program
        Permission::create(['name' => 'jurusan-program.index']);
        Permission::create(['name' => 'jurusan-program.create']);
        Permission::create(['name' => 'jurusan-program.edit']);
        Permission::create(['name' => 'jurusan-program.destroy']);

        //Prodi
        Permission::create(['name' => 'program-studi.index']);
        Permission::create(['name' => 'program-studi.create']);
        Permission::create(['name' => 'program-studi.edit']);
        Permission::create(['name' => 'program-studi.destroy']);

        //gedung
        Permission::create(['name' => 'gedung.index']);
        Permission::create(['name' => 'gedung.create']);
        Permission::create(['name' => 'gedung.edit']);
        Permission::create(['name' => 'gedung.destroy']);

        //ruangan
        Permission::create(['name' => 'ruangan.index']);
        Permission::create(['name' => 'ruangan.create']);
        Permission::create(['name' => 'ruangan.edit']);
        Permission::create(['name' => 'ruangan.destroy']);

        //internal-organisasi
        Permission::create(['name' => 'internal-organisasi.index']);
        Permission::create(['name' => 'internal-organisasi.create']);
        Permission::create(['name' => 'internal-organisasi.edit']);
        Permission::create(['name' => 'internal-organisasi.destroy']);

        //eksternal-organisasi
        Permission::create(['name' => 'eksternal-organisasi.index']);
        Permission::create(['name' => 'eksternal-organisasi.create']);
        Permission::create(['name' => 'eksternal-organisasi.edit']);
        Permission::create(['name' => 'eksternal-organisasi.destroy']);

        //dosen
        Permission::create(['name' => 'dosen.index']);
        Permission::create(['name' => 'dosen.create']);
        Permission::create(['name' => 'dosen.edit']);
        Permission::create(['name' => 'dosen.destroy']);

        //mahasiswa
        Permission::create(['name' => 'mahasiswa.index']);
        Permission::create(['name' => 'mahasiswa.create']);
        Permission::create(['name' => 'mahasiswa.edit']);
        Permission::create(['name' => 'mahasiswa.destroy']);

        //admin
        Permission::create(['name' => 'admin.index']);
        Permission::create(['name' => 'admin.create']);
        Permission::create(['name' => 'admin.edit']);
        Permission::create(['name' => 'admin.destroy']);

        //pengguna-luar
        Permission::create(['name' => 'pengguna-luar.index']);
        Permission::create(['name' => 'pengguna-luar.create']);
        Permission::create(['name' => 'pengguna-luar.edit']);
        Permission::create(['name' => 'pengguna-luar.destroy']);

        // create roles 
        $roleUser = Role::create(['name' => 'admin']);
        $roleUser->givePermissionTo([
            'dashboard',
            'user.management',
            'user.index',
        ]);

        // create Super Admin
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        $roleDosen = Role::create(['name' => 'dosen']);
        $roleMahasiswa = Role::create(['name' => 'mahasiswa']);
        $roleUmum = Role::create(['name' => 'umum']);

        //assign user id 1 ke super admin
        $user = User::find(1);
        $user->assignRole('super-admin');
        $user = User::find(2);
        $user->assignRole('admin');

        // You can assign other users as needed, for example:
        $user = User::find(3);
        $user->assignRole('dosen');

        $user = User::find(4);
        $user->assignRole('mahasiswa');

        $user = User::find(5);
        $user->assignRole('umum');
    }
}
