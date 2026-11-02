<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudPedidoRequest;
use App\Models\SolicitudPedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SolicitudPedidoController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // Por defecto 15 por página; si el valor no es válido se usa 15, y el máximo es 100
        $porPagina = (int) $request->query('per_page', 15);
        if ($porPagina < 1) {
            $porPagina = 15;
        }
        $porPagina = min($porPagina, 100);

        $pagina = SolicitudPedido::orderBy('id')->paginate($porPagina);

        return response()->json([
            'data' => $pagina->items(),
            'meta' => [
                'page' => $pagina->currentPage(),
                'per_page' => $pagina->perPage(),
                'total' => $pagina->total(),
                'last_page' => $pagina->lastPage(),
            ],
        ]);
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