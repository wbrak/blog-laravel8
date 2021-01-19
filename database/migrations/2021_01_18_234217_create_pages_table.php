<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 60)->nullable();
            $table->string('slug', 75)->nullable();
            $table->longText('content')->nullable();
            $table->enum('status', ['Disabled', 'Activated']);
            $table->string('keywords', 255)->nullable();
            $table->string('description', 155)->nullable();
            $table->enum('robots', ['Noindex-Nofollow', 'Index-Follow', 'Noindex-Follow', 'Index-Nofollow']);
            $table->boolean('is_default_home')->nullable();
            $table->boolean('is_default_not_found')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
