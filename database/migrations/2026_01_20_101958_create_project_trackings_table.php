<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('project_trackings', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('company')->default('MCC');
            $table->string('client');
            $table->string('project');
            $table->string('location');
            $table->decimal('cost', 20, 2)->nullable();
            $table->text('activity')->nullable();
            $table->text('progress')->nullable();
            $table->string('responsible')->nullable();
            $table->enum('status', ['on_track', 'at_risk', 'delayed', 'completed'])->default('on_track');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_trackings');
    }
};