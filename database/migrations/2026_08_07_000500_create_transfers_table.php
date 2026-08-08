<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_account_id')->constrained('financial_accounts')->cascadeOnDelete();
            $table->foreignId('to_account_id')->constrained('financial_accounts')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->date('transfer_date');
            $table->string('description')->nullable();
            $table->string('status', 12)->default('pending');
            $table->date('settled_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'transfer_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
