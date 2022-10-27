<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVentaEstadoAPIRequest;
use App\Http\Requests\API\UpdateVentaEstadoAPIRequest;
use App\Models\VentaEstado;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VentaEstadoController
 * @package App\Http\Controllers\API
 */

class VentaEstadoAPIController extends AppBaseController
{
    /**
     * Display a listing of the VentaEstado.
     * GET|HEAD /ventaEstados
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = VentaEstado::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $ventaEstados = $query->get();

        return $this->sendResponse($ventaEstados->toArray(), 'Venta Estados retrieved successfully');
    }

    /**
     * Store a newly created VentaEstado in storage.
     * POST /ventaEstados
     *
     * @param CreateVentaEstadoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVentaEstadoAPIRequest $request)
    {
        $input = $request->all();

        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::create($input);

        return $this->sendResponse($ventaEstado->toArray(), 'Venta Estado guardado exitosamente');
    }

    /**
     * Display the specified VentaEstado.
     * GET|HEAD /ventaEstados/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            return $this->sendError('Venta Estado no encontrado');
        }

        return $this->sendResponse($ventaEstado->toArray(), 'Venta Estado retrieved successfully');
    }

    /**
     * Update the specified VentaEstado in storage.
     * PUT/PATCH /ventaEstados/{id}
     *
     * @param int $id
     * @param UpdateVentaEstadoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVentaEstadoAPIRequest $request)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            return $this->sendError('Venta Estado no encontrado');
        }

        $ventaEstado->fill($request->all());
        $ventaEstado->save();

        return $this->sendResponse($ventaEstado->toArray(), 'VentaEstado actualizado con éxito');
    }

    /**
     * Remove the specified VentaEstado from storage.
     * DELETE /ventaEstados/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            return $this->sendError('Venta Estado no encontrado');
        }

        $ventaEstado->delete();

        return $this->sendSuccess('Venta Estado deleted successfully');
    }
}
