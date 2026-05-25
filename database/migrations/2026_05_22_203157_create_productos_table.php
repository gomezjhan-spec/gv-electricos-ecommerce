<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {

            $table->id();

            $table->string('nombre');

            $table->string('referencia')->unique();

            $table->text('descripcion')->nullable();

            $table->decimal('precio_detal', 10, 2);

            $table->decimal('precio_mayoreo', 10, 2)->nullable();

            $table->integer('cantidad_minima_mayoreo')->default(10);

            $table->integer('stock')->default(0);

            $table->string('imagen')->nullable();

            $table->string('categoria');

            $table->boolean('disponible_mayoreo')->default(true);

            $table->boolean('activo')->default(true);

            $table->boolean('destacado')->default(false);

            $table->string('badge')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};