<?php

use Illuminate\Database\Seeder;

class SubmenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(\SIGA\Submenu::class)->create([
            'title'=>"Companies",
            'name'=>"admin.companies.index",
            'path'=>"admin/companies",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>1,
            'description'=>"Companies page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);

        factory(\SIGA\Submenu::class)->create([
            'title'=>"Users",
            'name'=>"admin.users.index",
            'path'=>"admin/users",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>2,
            'description'=>"Users page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);

        factory(\SIGA\Submenu::class)->create([
            'title'=>"Roles",
            'name'=>"admin.roles.index",
            'path'=>"admin/roles",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>3,
            'description'=>"Roles Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);

        factory(\SIGA\Submenu::class)->create([
            'title'=>"Permissions",
            'name'=>"admin.permissions.index",
            'path'=>"admin/permissions",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>4,
            'description'=>"Permissions Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);


        factory(\SIGA\Submenu::class)->create([
            'title'=>"Menus",
            'name'=>"admin.menus.index",
            'path'=>"admin/menus",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>5,
            'description'=>"Menus Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);


        factory(\SIGA\Submenu::class)->create([
            'title'=>"Sub Menus",
            'name'=>"admin.sub-menus.index",
            'path'=>"admin/sub-menus",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>6,
            'description'=>"Sub Menus Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);


        factory(\SIGA\Submenu::class)->create([
            'title'=>"Categories",
            'name'=>"admin.categories.index",
            'path'=>"admin/categories",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>1,
            'description'=>"Categories Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);


        factory(\SIGA\Submenu::class)->create([
            'title'=>"Posts",
            'name'=>"admin.posts.index",
            'path'=>"admin/posts",
            'url'=>null,
            'auth'=>"yes",
            'icone'=>"angle",
            'ordering'=>3,
            'description'=>"Posts Page",
            'created_at'=>  date("Y-m-d"),
            'updated_at'=> date("Y-m-d")
        ]);
    }
}
