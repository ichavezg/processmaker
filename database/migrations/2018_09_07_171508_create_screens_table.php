<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScreensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screens', function (Blueprint $table) {
            // NOTE: Remember to update ScreenVersions when updating this table
            $table->increments('id');
            $table->unsignedInteger('screen_category_id')->nullable();
            $table->text('title');
            $table->text('description');
            $table->string('type', 20)->default('FORM');
            $table->json('config')->nullable();
            $table->json('computed')->nullable();
            $table->text('custom_css')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('screen_category_id');

        });
        Schema::table('processes', function($table) {
            $table->foreign('cancel_screen_id')->references('id')->on('screens');
            $table->foreign('request_detail_screen_id')->references('id')->on('screens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('processes', function($table) {
            $table->dropForeign(['cancel_screen_id']);
            $table->dropForeign(['request_detail_screen_id']);
        });
        Schema::dropIfExists('screens');
    }
}
