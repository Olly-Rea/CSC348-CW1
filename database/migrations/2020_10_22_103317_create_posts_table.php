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
    public function up() {
        Schema::create('posts', function (Blueprint $table) {
            // Define primary key
            $table->id('post_id');
            // Define foreign key
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            // Define table contents
            $table->text("title");
            $table->text("content");
            $table->string("tags")->nullable();
            $table->integer("likes");
            $table->integer("dislikes");
            // Add created_at & updated_at attributes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('posts');
    }
}
