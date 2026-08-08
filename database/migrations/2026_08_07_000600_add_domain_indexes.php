<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table): void {
            $table->index(['user_id', 'type', 'is_archived']);
        });
        Schema::table('financial_accounts', function (Blueprint $table): void {
            $table->index(['user_id', 'is_archived']);
        });
        Schema::table('credit_cards', function (Blueprint $table): void {
            $table->index(['user_id', 'is_archived']);
        });
        Schema::table('transaction_series', function (Blueprint $table): void {
            $table->index(['user_id', 'is_active']);
        });
        Schema::table('transaction_occurrences', function (Blueprint $table): void {
            $table->index(['user_id', 'status', 'due_date']);
        });
        Schema::table('budgets', function (Blueprint $table): void {
            $table->index(['user_id', 'month', 'is_active']);
        });
        Schema::table('transfers', function (Blueprint $table): void {
            $table->index(['user_id', 'status', 'transfer_date']);
        });
    }

    public function down(): void
    {
        Schema::table('transfers', fn (Blueprint $table) => $table->dropIndex('transfers_user_id_status_transfer_date_index'));
        Schema::table('budgets', fn (Blueprint $table) => $table->dropIndex('budgets_user_id_month_is_active_index'));
        Schema::table('transaction_occurrences', fn (Blueprint $table) => $table->dropIndex('transaction_occurrences_user_id_status_due_date_index'));
        Schema::table('transaction_series', fn (Blueprint $table) => $table->dropIndex('transaction_series_user_id_is_active_index'));
        Schema::table('credit_cards', fn (Blueprint $table) => $table->dropIndex('credit_cards_user_id_is_archived_index'));
        Schema::table('financial_accounts', fn (Blueprint $table) => $table->dropIndex('financial_accounts_user_id_is_archived_index'));
        Schema::table('categories', fn (Blueprint $table) => $table->dropIndex('categories_user_id_type_is_archived_index'));
    }
};
