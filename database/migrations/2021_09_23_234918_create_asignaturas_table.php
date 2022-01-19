<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('grupo_id')
                ->nullable()
                ->constrained('grupos')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->unsignedBigInteger('carga')->nullable();
            $table->foreignId('actividade_id')
                ->nullable()
                ->constrained('actividades')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('docencia_id')
                ->nullable()
                ->constrained('docencias')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('estado_id')
                ->nullable()
                ->constrained('estados')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('asignaturas');
    }
}
