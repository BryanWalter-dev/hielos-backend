<?php

namespace Database\Seeders;

use App\Models\SolicitudPedido;
use Illuminate\Database\Seeder;

class SolicitudPedidoSeeder extends Seeder
{
    public function run(): void
    {
        SolicitudPedido::factory()->count(15)->create();
    }
}