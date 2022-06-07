<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('Kpis', function (Blueprint $table) {
            $table->id();
            $table->text('type_graph');
            $table->text('name')->unique();
            $table->integer('expected_value')->nullable();
            $table->timestampTz('datetime')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('Kpis');
    }
};
