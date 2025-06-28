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
            $table->string('code');
            $table->foreignUuid('resident_id')->constrained('residents')->onDelete('cascade');
            $table->foreignUuid('house_id')->constrained('houses')->onDelete('cascade');
            $table->date('payment_date')->default(now());
            $table->enum('status', array_map(fn($case) => $case->value, PaymentStatus::cases()))->default(PaymentStatus::BelumLunas);
            $table->text('description')->nullable();
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
