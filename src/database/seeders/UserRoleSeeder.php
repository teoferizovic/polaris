<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    UserRole::updateOrCreate(
	    	['id' => 1],
	    	['name' => 'Admin']
		);

		UserRole::updateOrCreate(
	    	['id' => 2],
	    	['name' => 'Advanced User']
		);

		UserRole::updateOrCreate(
	    	['id' => 3],
	    	['name' => 'User']
		);
    }
}
