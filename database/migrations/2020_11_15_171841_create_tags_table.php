<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Create Table
        Schema::create('tags', function (Blueprint $table): void {
            // Primary key
            $table->id();
            // Table content
            $table->string('name');
        });

        // post_tags pivot table
        Schema::create('post_tags', function (Blueprint $table): void {
            // Foreign keys (and constraints)
            $table->foreignId('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('tag_id')->references('id')->on('tags')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
}
