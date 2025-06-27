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
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('expense_type'); //tipe pengeluaran, Mendeskripsikan apa yang dibeli security_salary, road_repair, electricity
            $table->decimal('amount', 8, 2);
            $table->date('date');
            $table->text('description');
            $table->string('category'); //routine, emergency, administrative
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
