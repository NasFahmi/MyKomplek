<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('fee_type_id')->references('id')->on('fee_types')->onDelete('cascade')->onUpdate('cascade'); //relasi ke fee_type
            $table->foreignUuid('payment_id')->references('id')->on('payments')->onDelete('cascade')->onUpdate('cascade'); //relasi ke payment
            $table->decimal('amount', 8, 2); //harga dari fee 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
