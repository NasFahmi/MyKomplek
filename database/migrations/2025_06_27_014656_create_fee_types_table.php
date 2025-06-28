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
        Schema::create('fee_types', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID sebagai primary key

            $table->string('name'); // Buat unik jika nama tidak boleh duplikat
            $table->text('description')->nullable(); // Buat nullable jika tidak wajib
            $table->decimal('amount', 10, 2); // Tambah presisi dan skala (10 total digit, 2 digit di belakang koma)
            $table->boolean('is_active')->default(true); // Default true agar aktif saat dibuat
            $table->date('effective_date')->default(now()); // Tanggal mulai berlaku
            $table->softDeletes(); // Untuk penghapusan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_types');
    }
};
