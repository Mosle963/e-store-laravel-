<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            'company_name'=>'tech company',
            'contact_name'=>'Ahmad',
            'city'=>'Damascus',
            'country'=>'Syria',
            'Phone'=>'33324587',
            'Fax'=>'33324588',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);

    DB::table('suppliers')->insert([
        'company_name'=>'Durra',
        'contact_name'=>'سعيد',
        'city'=>'دمشق',
        'country'=>'سوريا',
        'Phone'=>'0113855454',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()

    ]);


    DB::table('suppliers')->insert([
        'company_name'=>'كهربائيات المصري',
        'contact_name'=>'محمود',
        'city'=>'حلب',
        'country'=>'سوريا',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now()
        ]);

    }
}
