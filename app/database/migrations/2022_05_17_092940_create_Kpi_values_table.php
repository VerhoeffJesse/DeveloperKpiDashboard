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
        Schema::create('Kpi_values', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kpi_id');
            $table->integer('value_all');
            $table->text('value_date');
            $table->timestampTz('datetime')->useCurrent();
            $table->foreign('kpi_id')->references('id')->on('Kpis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('Kpi_values');
    }
};
