<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'Admin',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('1111'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'name'=>'User',
                'email'=>'user@gmail.com',
                'password'=>Hash::make('1111'),
                'role'=>'user',
                'status'=>'active'
            ),
        );

        DB::table('users')->insert($data);

        for($i = 0; $i<2; $i++ ){
        $user = \App\User::create([
            'name' => 'Proveedor',
            'username' => 'supplier'.$i,
            'email' => 'supplier'.$i.'@email.com',
            'password' => Hash::make('root1234'),
            'role' => 'user',
            'status' => 'active',
            'provider' => null,
            'provider_id' => null,
        ]);

        \App\Models\Supplier::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'last_name' => 'Proveedor',
            'type_document' => 'Cedula',
            'num_document' => '012345678'.$i,
            'address' => 'direccion',
            'phone' => '0123456789',
            'email' => $user->email,
        ]);
    }



    }
}
