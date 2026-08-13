<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->timestamp('onboarding_completed_at')->nullable();
        });

        Schema::create('onboarding_events', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tour', 80);
            $table->string('event', 30);
            $table->unsignedInteger('step')->nullable();
            $table->string('route', 120)->nullable();
            $table->timestamps();
            $table->index(['user_id', 'tour', 'created_at']);
        });

        Schema::create('support_feedback', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('article', 160)->nullable();
            $table->string('type', 30);
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_feedback');
        Schema::dropIfExists('onboarding_events');
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('onboarding_completed_at'));
    }
};
