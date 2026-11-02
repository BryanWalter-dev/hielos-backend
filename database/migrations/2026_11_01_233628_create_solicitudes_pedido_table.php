<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_pedido', function (Blueprint $table) {
            $table->id();
            $table->string('cliente', 100);
            $table->unsignedInteger('cantidad');
            $table->date('fecha_requerida');
            $table->string('estado', 20)->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_pedido');
    }
};