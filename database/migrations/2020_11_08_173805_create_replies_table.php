<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            // Define primary key
            $table->id('replyID');
            // Define foreign keys
            $table->foreignId('userID')->references('userID')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('commentID')->references('commentID')->on('comments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('replies');
    }
}
