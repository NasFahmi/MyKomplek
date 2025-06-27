<?php

use App\Enum\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('resident_id')->references('id')->on('residents')->onDelete('cascade')->onUpdate('cascade'); //relasi resident
            $table->foreignUuid('house_id')->references('id')->on('houses')->onDelete('cascade')->onUpdate('cascade'); //relasi house
            $table->date('payment_date');
            $table->integer('month'); //bulan
            $table->integer('year'); //tahun

            $table->enum('status', array_map(fn($case) => $case->value, PaymentStatus::cases()))->default(PaymentStatus::BelumLunas);

            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
