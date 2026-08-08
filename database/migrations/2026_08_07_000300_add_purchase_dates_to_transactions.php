<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaction_series', function (Blueprint $table): void {
            $table->date('purchase_date')->nullable()->after('starts_on');
        });

        Schema::table('transaction_occurrences', function (Blueprint $table): void {
            $table->date('purchase_date')->nullable()->after('due_date');
        });

        DB::table('transaction_series')->update(['purchase_date' => DB::raw('starts_on')]);
        DB::table('transaction_occurrences')->update(['purchase_date' => DB::raw('due_date')]);
    }

    public function down(): void
    {
        Schema::table('transaction_occurrences', function (Blueprint $table): void {
            $table->dropColumn('purchase_date');
        });

        Schema::table('transaction_series', function (Blueprint $table): void {
            $table->dropColumn('purchase_date');
        });
    }
};
