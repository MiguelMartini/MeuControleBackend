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
            $table->foreignId('user_id')
          ->constrained()
          ->cascadeOnDelete();

    $table->foreignId('card_id')
          ->constrained()
          ->cascadeOnDelete();
            
            $table->string('title', 30);
            $table->string('description', 50)->nullable();
            $table->decimal('value', 10,2);
            $table->integer('number_installment')->nullable();
            $table->enum('payment_method', ['Credit_Card', 'Debit_Card', 'Pix']);
            $table->string('responsible', 30)->nullable();
            $table->enum('status', ['Open', 'Partial_Paid', 'Paid'])->default('Open');
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
