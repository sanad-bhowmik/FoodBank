<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '1024M');

        $this->call(SettingTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(BackendMenuTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(AdminPermissionTableSeeder::class);
        $this->call(FooterMenuSectionTableSeeder::class);
        $this->call(TemplateTableSeeder::class);
        $this->call(PageTableSeeder::class);
        $this->call(LanguageSeeder::class);
    }
}
