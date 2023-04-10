<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_role_id');
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->unsignedBigInteger('feature_id');
            $table->foreign('feature_id')->references('id')->on('features');
            $table->boolean('create_data');
            $table->boolean('read_data');
            $table->boolean('update_data');
            $table->boolean('delete_data');
            $table->timestamps();
        });

        Artisan::call('db:seed', array('--class' => 'FeaturePermissionSeeder'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_permissions');
    }
}
