<?php

namespace Database\Seeders;

use Modules\User\Entities\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::factory()->count(10)->create();
    }
}
