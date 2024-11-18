<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpeditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
	{
		DB::table('expeditions')->insert([
			['name' => 'Expedition A', 'contact_info' => '123-456-789'],
			['name' => 'Expedition B', 'contact_info' => '987-654-321'],
		]);
	}
}
