<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

use Ramsey\Uuid\Type\Decimal;

class products extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      

        DB::table('products')->insert([
            'name' => Str::random(10),
            'description' => Str::random(10),
           // 'price' => $faker->randomNumber ,
        ]);
    }
}
