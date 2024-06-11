<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('content', function (Blueprint $table): void {
            // Define primary key
            $table->id();
            // Define foreign key
            $table->foreignId('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            // Define content position (and old positon) in post
            $table->integer('position');
            // Make the pairing unique
            $table->unique(['post_id', 'position']);
            // Define table contents
            $table->string('type');
            $table->text('content');
            $table->text('sub_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('content');
    }
}
