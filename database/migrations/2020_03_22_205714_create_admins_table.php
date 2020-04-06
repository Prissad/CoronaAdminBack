<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments("id");
            $table->string('name');
            $table->integer('phone');
            $table->integer('cin');
            $table->string('email');
            $table->string('password');
            $table->integer('delegation_id')->unsigned()->nullable();
            //$table->rememberToken();
        });

        Schema::table('admins', function($table) {
            $table->foreign("delegation_id")->references("id")->on("delegations")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
