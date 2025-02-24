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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('Quotation_ref');
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('service_id');
            $table->string('service_type');
            $table->longText('items');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->decimal('tax', 10, 2)->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('penalty', 10, 2)->nullable();
            $table->decimal('Cancellation', 10, 2)->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
