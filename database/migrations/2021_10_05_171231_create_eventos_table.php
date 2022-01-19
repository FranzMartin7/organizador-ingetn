<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignatura_id')
                ->nullable()
                ->constrained('asignaturas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('actividade_id')
                ->nullable()
                ->constrained('actividades')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('aula_id')
                ->nullable()
                ->constrained('aulas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->longText('descripcion')->nullable();
            $table->longText('enlace')->nullable();
            $table->date('fecha');
            $table->time('horaInicio', $precision = 0);
            $table->time('horaFinal', $precision = 0);
            $table->foreignId('acontecimiento_id')
                ->nullable()
                ->constrained('acontecimientos')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('eventos');
    }
}
