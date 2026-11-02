<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudPedidoRequest;
use App\Models\SolicitudPedido;
use Illuminate\Http\JsonResponse;

class SolicitudPedidoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => SolicitudPedido::orderBy('id')->get()]);
    }

    public function store(SolicitudPedidoRequest $request): JsonResponse
    {
        $solicitud = SolicitudPedido::create($request->validated());

        return response()->json(['data' => $solicitud->fresh()], 201);
    }

    public function show(int $id): JsonResponse
    {
        $solicitud = SolicitudPedido::find($id);

        if (! $solicitud) {
            return $this->noEncontrada();
        }

        return response()->json(['data' => $solicitud]);
    }

    public function update(SolicitudPedidoRequest $request, int $id): JsonResponse
    {
        $solicitud = SolicitudPedido::find($id);

        if (! $solicitud) {
            return $this->noEncontrada();
        }

        $solicitud->update($request->validated());

        return response()->json(['data' => $solicitud->fresh()]);
    }

    public function destroy(int $id): JsonResponse
    {
        $solicitud = SolicitudPedido::find($id);

        if (! $solicitud) {
            return $this->noEncontrada();
        }

        $solicitud->delete();

        return response()->json(null, 204);
    }

    private function noEncontrada(): JsonResponse
    {
        return response()->json(['message' => 'Solicitud de pedido no encontrada.'], 404);
    }
}