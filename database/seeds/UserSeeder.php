<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('users')->insert([
            'user_id' => '000001',
            'user_name' => 'davin',
            'user_password' => hash('sha256', 'user_password'),
            'email' => 'davin@gmail.com',
            'position_id' => 1,
            'department_id' => 1,
            'role_id' => 1,
            'branch_id' => 1,
            'created_by' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_by' =>1,
            'updated_at' =>1,
        ]);

    }
}
