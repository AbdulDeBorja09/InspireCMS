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
            $table->string('Quotation_ref')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('date_time');
            $table->string('serive_type');
            $table->string('serive_name');
            $table->string('description');
            $table->string('qty');
            $table->decimal('tax', 10, 2)->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('penalty', 10, 2)->nullable();
            $table->decimal('Cancellation', 10, 2)->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->boolean('status')->default('0');
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
