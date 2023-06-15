<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('source')->nullable();
            $table->string('author')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->string('url')->nullable();
            $table->string('url_image')->nullable();
            $table->text('content')->nullable();
            $table->dateTime('published_at');
            $table->timestamps();
            $table->foreign('category_id', 'categoryArticle')
                ->references('id')
                ->on('categories')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
