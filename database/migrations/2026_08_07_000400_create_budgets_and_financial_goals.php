<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->date('month');
            $table->decimal('amount', 15, 2);
            $table->unsignedTinyInteger('alert_threshold')->default(80);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['user_id', 'month']);
        });

        Schema::create('financial_goals', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0);
            $table->date('deadline')->nullable();
            $table->string('color', 20)->default('emerald');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'is_completed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financial_goals');
        Schema::dropIfExists('budgets');
    }
};
