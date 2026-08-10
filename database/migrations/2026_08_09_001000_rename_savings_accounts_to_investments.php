<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('financial_accounts')
            ->where('type', 'savings')
            ->update(['type' => 'investments']);
    }

    public function down(): void
    {
        DB::table('financial_accounts')
            ->where('type', 'investments')
            ->update(['type' => 'savings']);
    }
};
