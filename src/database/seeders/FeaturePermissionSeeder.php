<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeaturePermission;

class FeaturePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FeaturePermission::updateOrCreate(
	    	['user_role_id' => 1, 'feature_id' => 1],
	    	['create_data' => true, 'read_data' => true, 'update_data' => true, 'delete_data' => true]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 1, 'feature_id' => 2],
	    	['create_data' => true, 'read_data' => true, 'update_data' => true, 'delete_data' => true]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 1, 'feature_id' => 3],
	    	['create_data' => true, 'read_data' => true, 'update_data' => true, 'delete_data' => true]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 2, 'feature_id' => 1],
	    	['create_data' => true, 'read_data' => true, 'update_data' => false, 'delete_data' => false]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 2, 'feature_id' => 2],
	    	['create_data' => true, 'read_data' => true, 'update_data' => false, 'delete_data' => false]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 2, 'feature_id' => 3],
	    	['create_data' => true, 'read_data' => true, 'update_data' => false, 'delete_data' => false]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 3, 'feature_id' => 1],
	    	['create_data' => false, 'read_data' => true, 'update_data' => false, 'delete_data' => false]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 3, 'feature_id' => 2],
	    	['create_data' => false, 'read_data' => true, 'update_data' => false, 'delete_data' => false]
		);

		FeaturePermission::updateOrCreate(
	    	['user_role_id' => 3, 'feature_id' => 3],
	    	['create_data' => false, 'read_data' => true, 'update_data' => false, 'delete_data' => false]
		);

    }
}
