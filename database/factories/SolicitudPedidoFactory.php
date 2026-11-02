<?php

namespace Database\Factories;

use App\Models\SolicitudPedido;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudPedidoFactory extends Factory
{
    protected $model = SolicitudPedido::class;

    public function definition(): array
    {
        return [
            'cliente' => fake()->name(),
            'cantidad' => fake()->numberBetween(1, 200),
            'fecha_requerida' => fake()->dateTimeBetween('now', '+30 days')->format('Y-m-d'),
            'estado' => fake()->randomElement(SolicitudPedido::ESTADOS),
        ];
    }
}