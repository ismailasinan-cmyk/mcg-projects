<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('project_trackings', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('project_trackings', function (Blueprint $table) {
            $table->enum('status', ['moving_forward', 'in_progress', 'no_progress'])->default('in_progress')->after('responsible');
        });
    }

    public function down(): void
    {
        Schema::table('project_trackings', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('project_trackings', function (Blueprint $table) {
            $table->enum('status', ['on_track', 'at_risk', 'delayed', 'completed'])->default('on_track')->after('responsible');
        });
    }
};