<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            'first_name'=>'Mohamad',
            'last_name'=>'Zid',
            'city'=>'Beirut',
            'country'=>'Lebanon',
            'phone'=>'02015485546',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('customers')->insert([
            'first_name'=>'Samer',
            'last_name'=>'Salam',
            'city'=>'Damascus',
            'country'=>'Syria',
            'phone'=>'555456687',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
