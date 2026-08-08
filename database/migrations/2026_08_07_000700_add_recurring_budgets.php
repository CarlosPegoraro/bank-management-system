<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('budgets', function (Blueprint $table): void {
            $table->boolean('is_recurring')->default(false)->after('is_active');
            $table->index(['user_id', 'is_recurring', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::table('budgets', function (Blueprint $table): void {
            $table->dropIndex('budgets_user_id_is_recurring_is_active_index');
            $table->dropColumn('is_recurring');
        });
    }
};
