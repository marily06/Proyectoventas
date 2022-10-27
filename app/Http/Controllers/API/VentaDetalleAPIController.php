<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVentaDetalleAPIRequest;
use App\Http\Requests\API\UpdateVentaDetalleAPIRequest;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VentaDetalleController
 * @package App\Http\Controllers\API
 */

class VentaDetalleAPIController extends AppBaseController
{
    /**
     * Display a listing of the VentaDetalle.
     * GET|HEAD /ventaDetalles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = VentaDetalle::with(['item']);

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }


        if ($request->venta_id){
            $query->where('venta_id',$request->venta_id);
        }

        $ventaDetalles = $query->get();

        return $this->sendResponse($ventaDetalles->toArray(), 'Venta Detalles retrieved successfully');
    }

    /**
     * Store a newly created VentaDetalle in storage.
     * POST /ventaDetalles
     *
     * @param CreateVentaDetalleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVentaDetalleAPIRequest $request)
    {
        $input = $request->all();

        /** @var VentaDetalle $ventaDetalle */
        $ventaDetalle = VentaDetalle::create($input);

        return $this->sendResponse($ventaDetalle->toArray(), 'Venta Detalle guardado exitosamente');
    }

    /**
     * Display the specified VentaDetalle.
     * GET|HEAD /ventaDetalles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VentaDetalle $ventaDetalle */
        $ventaDetalle = VentaDetalle::find($id);

        if (empty($ventaDetalle)) {
            return $this->sendError('Venta Detalle no encontrado');
        }

        return $this->sendResponse($ventaDetalle->toArray(), 'Venta Detalle retrieved successfully');
    }

    /**
     * Update the specified VentaDetalle in storage.
     * PUT/PATCH /ventaDetalles/{id}
     *
     * @param int $id
     * @param UpdateVentaDetalleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVentaDetalleAPIRequest $request)
    {
        /** @var VentaDetalle $ventaDetalle */
        $ventaDetalle = VentaDetalle::find($id);

        if (empty($ventaDetalle)) {
            return $this->sendError('Venta Detalle no encontrado');
        }

        $ventaDetalle->fill($request->all());
        $ventaDetalle->save();

        return $this->sendResponse($ventaDetalle->toArray(), 'VentaDetalle actualizado con éxito');
    }

    /**
     * Remove the specified VentaDetalle from storage.
     * DELETE /ventaDetalles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VentaDetalle $ventaDetalle */
        $ventaDetalle = VentaDetalle::find($id);

        if (empty($ventaDetalle)) {
            return $this->sendError('Venta Detalle no encontrado');
        }

        $ventaDetalle->delete();

        return $this->sendSuccess('Venta Detalle deleted successfully');
    }
}
