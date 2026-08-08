<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('credit_cards', function (Blueprint $table): void {
            $table->string('bin', 8)->nullable()->after('brand');
            $table->string('issuer')->nullable()->after('bin');
            $table->string('country', 100)->nullable()->after('issuer');
            $table->string('card_type', 20)->nullable()->after('country');
            $table->json('metadata')->nullable()->after('card_type');
        });
    }

    public function down(): void
    {
        Schema::table('credit_cards', function (Blueprint $table): void {
            $table->dropColumn(['bin', 'issuer', 'country', 'card_type', 'metadata']);
        });
    }
};
