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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no', 20);
            $table->string('invoice_uid', 30);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('purchase_order', 50)->nullable();
            $table->date('issue_date');
            $table->date('due_date');
            $table->double('subtotal');
            $table->double('total');
            $table->double('paid_amount');
            $table->double('due_amount');
            $table->text('note')->nullable();
            $table->string('tax_title', 150)->nullable();
            $table->float('tax_percentage')->nullable();
            $table->float('tax_amount')->nullable();
            $table->string('second_tax_title', 150)->nullable();
            $table->float('second_tax_percentage')->nullable();
            $table->float('second_tax_amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
