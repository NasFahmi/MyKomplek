<?php

use App\Enum\ResidentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('identity_photo')->nullable();
            $table->string('phone_number');
            $table->enum('status', array_map(fn($case) => $case->value, ResidentStatus::cases()))
                ->default(ResidentStatus::Tetap->value); //untuk menyimpan status dari penghuni apakah penghuni tetap, atau penghuni kontrak
            $table->boolean('married_status')->default(1); //simpan data status married
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
