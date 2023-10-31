<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Faker\Factory as Faker;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Admin::create([
            'name'      =>  $faker->name,
            'email'     =>  'admin@admin.com',
            'password'  =>  bcrypt('password'),
        ]);
    }
}
