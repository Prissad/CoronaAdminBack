<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => "admin",
            'phone' => "12345678",
            'cin' => "98765432",
            'email' => "admin@admin.com",
            'password' => Hash::make("admin"),
            'delegation_id' => 0,
        ]);
    }
}
