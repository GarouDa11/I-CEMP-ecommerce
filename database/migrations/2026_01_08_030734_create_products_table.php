<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('sold_count')->default(0); // How many people bought
            $table->string('material')->nullable(); // What it's made from
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('category'); // merch, tech, arts, clothing
            $table->foreignId('committee_id')->constrained('committees')->onDelete('cascade');
            $table->string('main_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};