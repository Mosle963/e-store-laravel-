<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'order_date' => Carbon::create(2020, 7, 5),
            'order_number' => '5',
            'customer_id' => 1,
            'total_amount' => 1000,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('orders')->insert([
            'order_date' => Carbon::create(2020, 8, 14),
            'order_number' => '8',
            'customer_id' => 2,
            'total_amount' => 800,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
