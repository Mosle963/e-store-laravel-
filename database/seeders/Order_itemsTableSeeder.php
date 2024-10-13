<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Order_itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order_items')->insert([
            'order_id' => 1,
            'product_id' => 4,
            'product_name' => 'Biscuit',
            'unit_price' => 500,
            'quantity' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('order_items')->insert([
            'order_id' => 2,
            'product_id' => 3,
            'product_name' => 'Sugar',
            'unit_price' => 250,
            'quantity' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('order_items')->insert([
            'order_id' => 2,
            'product_id' => 2,
            'product_name' => 'Rice',
            'unit_price' => 300,
            'quantity' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
