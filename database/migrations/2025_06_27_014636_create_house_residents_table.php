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
        Schema::create('house_residents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date_of_entry');
            $table->date('date_of_exit')->nullable();
            $table->foreignUuid('house_id')->references('id')->on('houses')->onDelete('cascade');
            $table->foreignUuid('resident_id')->references('id')->on('residents')->onDelete('cascade');
            $table->softDeletes(); //soft delete untuk history
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_residents');
    }
};
