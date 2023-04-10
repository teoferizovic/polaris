<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Feature::updateOrCreate(
	    	['id' => 1],
	    	['name' => 'Users']
		);

		Feature::updateOrCreate(
	    	['id' => 2],
	    	['name' => 'Products']
		);

		Feature::updateOrCreate(
	    	['id' => 3],
	    	['name' => 'Comments']
		);
    }
}
