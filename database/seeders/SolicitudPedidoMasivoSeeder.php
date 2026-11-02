<?php

namespace Database\Seeders;

use App\Models\SolicitudPedido;
use Illuminate\Database\Seeder;

class SolicitudPedidoMasivoSeeder extends Seeder
{
    // Genera 20.000 solicitudes ficticias para probar el rendimiento del listado
    public function run(): void
    {
        $ahora = now();

        for ($lote = 0; $lote < 20; $lote++) {
            $filas = [];

            for ($i = 0; $i < 1000; $i++) {
                $filas[] = [
                    'cliente' => fake()->name(),
                    'cantidad' => fake()->numberBetween(1, 200),
                    'fecha_requerida' => fake()->dateTimeBetween('now', '+60 days')->format('Y-m-d'),
                    'estado' => fake()->randomElement(SolicitudPedido::ESTADOS),
                    'created_at' => $ahora,
                    'updated_at' => $ahora,
                ];
            }

            // Inserta 1.000 filas por consulta (mucho más rápido que una por una)
            SolicitudPedido::insert($filas);
        }
    }
}