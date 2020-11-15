<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            // Define primary key
            $table->id('comment_id');
            // Define foreign keys
            $table->foreignId('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('post_id')->references('post_id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            // Define table contents
            $table->text("content");
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
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
