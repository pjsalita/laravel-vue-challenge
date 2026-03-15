<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('machine_states');

        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->string('name')->default('Container');
            $table->float('current')->default(0);
            $table->float('capacity')->default(0);
            $table->string('unit')->default('g');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};
