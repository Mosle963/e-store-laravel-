<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'product_name' => 'Chai',
            'supplier_id' => 1,
            'unit_price' => 150,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('products')->insert([
            'product_name' => 'Rice',
            'supplier_id' => 1,
            'unit_price' => 300,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('products')->insert([
            'product_name' => 'Sugar',
            'supplier_id' => 2,
            'unit_price' => 250,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ]);

        DB::table('products')->insert([
            'product_name' => 'Biscuit',
            'supplier_id' => 3,
            'unit_price' => 500,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
