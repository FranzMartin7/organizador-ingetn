<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')
                ->nullable()
                ->constrained('materias')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('semestre_id')
                ->nullable()
                ->constrained('semestres')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('mencione_id')
                ->nullable()
                ->constrained('menciones')
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programas');
    }
}
