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
            $table->string('bill_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->date('bill_date');
            $table->decimal('consultation_fee', 8, 2)->default(0);
            $table->decimal('medicine_cost', 8, 2)->default(0);
            $table->decimal('lab_charges', 8, 2)->default(0);
            $table->decimal('other_charges', 8, 2)->default(0);
            $table->decimal('total_amount', 8, 2);
            $table->decimal('paid_amount', 8, 2)->default(0);
            $table->decimal('due_amount', 8, 2);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'card', 'insurance', 'online'])->nullable();
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
