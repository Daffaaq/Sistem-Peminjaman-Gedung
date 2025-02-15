<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use Illuminate\Database\Seeder;

class MenuGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // MenuGroup::factory()->count(5)->create();
        MenuGroup::insert(
            [
                [
                    'name' => 'Dashboard',
                    'icon' => 'fas fa-tachometer-alt',
                    'permission_name' => 'dashboard',
                ],
                [
                    'name' => 'Master Management',  // Menambahkan Master Management
                    'icon' => 'fas fa-cogs', // Pilihan ikon, bisa disesuaikan
                    'permission_name' => 'master.management', // Nama permission yang sesuai
                ],
                [
                    'name' => 'Organisazation Management',  // Menambahkan Master Management
                    'icon' => 'fas fa-sitemap', // Pilihan ikon, bisa disesuaikan
                    'permission_name' => 'organization.management', // Nama permission yang sesuai
                ],
                [
                    'name' => 'Users Management',
                    'icon' => 'fas fa-users',
                    'permission_name' => 'user.management',
                ],
                [
                    'name' => 'Role Management',
                    'icon' => 'fas fa-user-tag',
                    'permisison_name' => 'role.permission.management',
                ],
                [
                    'name' => 'Menu Management',
                    'icon' => 'fas fa-bars',
                    'permisison_name' => 'menu.management',
                ]
            ]
        );
    }
}
