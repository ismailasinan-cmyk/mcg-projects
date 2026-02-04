<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('project_trackings', function (Blueprint $table) {
            $table->string('country')->nullable()->after('project');
            $table->string('lga')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_trackings', function (Blueprint $table) {
            $table->dropColumn(['country', 'lga']);
        });
    }
};
