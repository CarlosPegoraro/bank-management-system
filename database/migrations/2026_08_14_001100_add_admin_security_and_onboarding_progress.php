<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('role', 30)->default('user')->after('password');
            $table->timestamp('last_login_at')->nullable()->after('role');
            $table->index(['role', 'last_login_at']);
        });

        Schema::create('audit_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 80);
            $table->string('subject_type', 160)->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('metadata')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            $table->index(['action', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });

        Schema::create('onboarding_progress', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('step', 60);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'step']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboarding_progress');
        Schema::dropIfExists('audit_logs');
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex('users_role_last_login_at_index');
            $table->dropColumn(['role', 'last_login_at']);
        });
    }
};
