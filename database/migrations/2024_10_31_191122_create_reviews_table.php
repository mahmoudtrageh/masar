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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId(column: 'url_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId(column: 'category_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('rate')->default(0);
            $table->integer('category_duration')->nullable();
            $table->integer('url_duration')->nullable();
            $table->longText('review')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
