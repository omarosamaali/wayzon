<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('pending_plan', ['basic', 'smart', 'pro'])->nullable()->after('plan');
            $table->string('pending_plan_token', 64)->nullable()->unique()->after('pending_plan');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['pending_plan', 'pending_plan_token']);
        });
    }
};
