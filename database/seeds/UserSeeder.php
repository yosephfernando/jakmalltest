<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array (
            array(
                'name' => 'Herman Yoseph Fernando',
                'email' => 'fernandoyoseph6@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$12$ivCaQwz.E3L7VOEnYqZjQ.4JqCJJDOO1dG1opqrFpjulApEF78GLa', //test123
                'remember_token' => str_random(10),
                'created_at' => now(),
                'updated_at' => now(),
            )
        );
        DB::table('users')->insert($data);
    }
}
