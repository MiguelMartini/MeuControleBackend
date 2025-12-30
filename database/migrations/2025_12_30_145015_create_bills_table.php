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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('title', 30);
            $table->string('description', 50);
            $table->float('value', 2);
            $table->integer('number_installment');
            $table->enum('payment_method', ['Credit_Card', 'Debit_Card', 'Pix']);
            $table->enum('status', ['Open', 'Partial_Paid', 'Paid']);
            $table->string('responsible', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
