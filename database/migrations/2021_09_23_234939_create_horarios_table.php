<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignatura_id')
                ->nullable()
                ->constrained('asignaturas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->integer('dia')->nullable();
            $table->time('horaInicio', $precision = 0);
            $table->time('horaFinal', $precision = 0);
            $table->foreignId('aula_id')
                ->nullable()
                ->constrained('aulas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->integer('generado')->nullable();
            $table->foreignId('periodo_id')
                ->nullable()
                ->constrained('periodos')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->year('gestion');         
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
        Schema::dropIfExists('horarios');
    }
}
