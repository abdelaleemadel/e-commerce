<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table("products")->insert([
            "name" => "dell",
            "desc" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis incidunt a unde fuga magnam consectetur iure aliquam.",
            "price" => 20000,
            "image" => "products/2.png",
            "quantity" => 40,
            "category_id" => 2
        ]);
    }
}
