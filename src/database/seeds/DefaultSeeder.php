<?php


use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds. UPDATE `address` SET `addresable_type`='SIGA\User' WHERE `addresable_type`='App\User'
     *
     * @return void
     */
    public function run()
    {


      //  $this->addroles([
      //      'name' => "Super Admin 01",
      //      'email' => "admin@localhost.crm-01.test"
      //  ]);


        $this->addroles([
            'name' => "Super Admin 02",
            'email' => "admin@localhost.crm-02.test"
        ]);

       // $this->addroles([
       //     'name' => "Super Admin 03",
       //     'email' => "admin@localhost.crm-03.test"
      //  ]);

        Artisan::call("make:permissions");

    }

    protected function addroles($data){

        factory(\SIGA\Acl\Models\Role::class)->create([
            'name'=>'Super Admin',
            'slug'=>'uper-admin',
            'special'=>'all-access'
        ])->each(function ($role) use ($data){
            $this->users(1,$role,$data);
        });

        factory(\SIGA\Acl\Models\Role::class)->create([
            'name'=>'Gerente',
            'slug'=>'gerente',
            'special'=>null,
            'description'=>'Consegue fazer todas as operações no sistema',
        ])->each(function ($role){
            $this->users(1,$role);
        });

        factory(\SIGA\Acl\Models\Role::class)->create([
            'name'=>'Funcionário',
            'slug'=>'funcionario',
            'special'=>null,
            'description'=>'Consegue visualizar eventos',
        ])->each(function ($role)  {
            $this->users(5,$role);
        });

        factory(\SIGA\Acl\Models\Role::class)->create([
            'name'=>'Cliente',
            'slug'=>'cliente',
            'special'=>null,
            'description'=>'Consegue fazer pedidos, acompanhar pedidos ',
        ])->each(function ($role) {
            $this->users(10,$role);
        });
    }

    private function users($amount,$role,$data=[]){
        factory(\SIGA\User::class,$amount)->create($data)->each(function ($user) use ($role){
            $user->address()->save(factory(\SIGA\Addres::class)->make());
            $user->file()->save(factory(\SIGA\File::class)->make());
            $role->user_id = $user->id;
            $role->update();
            $user->roles()->sync($role);
            //$this->blog($user);
        });
    }


}
