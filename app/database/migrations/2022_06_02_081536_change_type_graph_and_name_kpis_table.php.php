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
        Schema::table('kpis', function (Blueprint $table) {
            $table->string('type_graph', 45)->change();
            $table->string('name', 45)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('kpis', function (Blueprint $table) {
            $table->text('type_graph')->change();
            $table->text('name')->change();
        });
    }
};
