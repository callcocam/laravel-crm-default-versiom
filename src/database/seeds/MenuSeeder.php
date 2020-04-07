<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\SIGA\Menu::class)->create([
            'title'=>"Dashboard",
            'name'=>"admin.dashboard",
            'path'=>"admin",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"dashborad",
            'ordering'=>1,
            'description'=>"Dashboard page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);


        factory(\SIGA\Menu::class)->create([
            'title'=>"Operational",
            'name'=>"admin.operational",
            'path'=>null,
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"gears",
            'ordering'=>2,
            'description'=>"Operational Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);


        factory(\SIGA\Menu::class)->create([
            'title'=>"Blog",
            'name'=>"admin.blog",
            'path'=>null,
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"gears",
            'ordering'=>2,
            'description'=>"Operational Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);

        factory(\SIGA\Menu::class)->create([
            'title'=>"Logout",
            'name'=>"admin.auth.logout",
            'path'=>"admin/logout",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"singout",
            'ordering'=>100,
            'description'=>"Logout System",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);
    }
}
