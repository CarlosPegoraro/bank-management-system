<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_cards', function (Blueprint $table): void {
            $table->foreignId('financial_account_id')
                ->nullable()
                ->after('user_id')
                ->constrained('financial_accounts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('credit_cards', function (Blueprint $table): void {
            $table->dropForeign(['financial_account_id']);
            $table->dropColumn('financial_account_id');
        });
    }
};
