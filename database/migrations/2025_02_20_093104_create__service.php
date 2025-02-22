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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->string('image4');
            $table->text('description')->nullable();
            $table->string('brief')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();
        });
        Schema::create('service_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->string('rate_type');
            $table->decimal('rate', 10, 2);
            $table->string('unit')->nullable();
            $table->text('inclusions')->nullable();
            $table->decimal('hour', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
        Schema::dropIfExists('service_rates');
    }
};
