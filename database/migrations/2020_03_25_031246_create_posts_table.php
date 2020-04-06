<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments("id");
            $table->double("longitude");
            $table->double("latitude");
            $table->string("type");
            $table->longText("urlToImage");
            $table->string("time");
            $table->boolean("affichage")->default(true);
            $table->string("description")->nullable();
            $table->integer("delegation_id")->unsigned();

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
        Schema::dropIfExists('posts');
    }
}
