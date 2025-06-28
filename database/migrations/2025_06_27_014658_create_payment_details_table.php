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
            $table->foreignUuid('fee_type_id')->constrained('fee_types')->onDelete('restrict'); // Ubah cascade ke restrict
            $table->foreignUuid('payment_id')->constrained('payments')->onDelete('cascade');
            $table->decimal('amount', 10, 2); //total
            $table->tinyInteger('month'); // <= Tambahkan ini
            $table->smallInteger('year'); // <= Tambahkan ini
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
