<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompraDetalleAPIRequest;
use App\Http\Requests\API\UpdateCompraDetalleAPIRequest;
use App\Models\CompraDetalle;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CompraDetalleController
 * @package App\Http\Controllers\API
 */

class CompraDetalleAPIController extends AppBaseController
{
    /**
     * Display a listing of the CompraDetalle.
     * GET|HEAD /compraDetalles
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = CompraDetalle::with(['item']);

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }

        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        if ($request->compra_id){
            $query->where('compra_id',$request->compra_id);
        }

        $compraDetalles = $query->get();

        return $this->sendResponse($compraDetalles->toArray(), 'Compra Detalles retrieved successfully');
    }

    /**
     * Store a newly created CompraDetalle in storage.
     * POST /compraDetalles
     *
     * @param CreateCompraDetalleAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraDetalleAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::create($input);

        return $this->sendResponse($compraDetalle->toArray(), 'Compra Detalle guardado exitosamente');
    }

    /**
     * Display the specified CompraDetalle.
     * GET|HEAD /compraDetalles/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            return $this->sendError('Compra Detalle no encontrado');
        }

        return $this->sendResponse($compraDetalle->toArray(), 'Compra Detalle retrieved successfully');
    }

    /**
     * Update the specified CompraDetalle in storage.
     * PUT/PATCH /compraDetalles/{id}
     *
     * @param int $id
     * @param UpdateCompraDetalleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraDetalleAPIRequest $request)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            return $this->sendError('Compra Detalle no encontrado');
        }

        $compraDetalle->fill($request->all());
        $compraDetalle->save();

        return $this->sendResponse($compraDetalle->toArray(), 'CompraDetalle actualizado con éxito');
    }

    /**
     * Remove the specified CompraDetalle from storage.
     * DELETE /compraDetalles/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            return $this->sendError('Compra Detalle no encontrado');
        }

        $compraDetalle->delete();

        return $this->sendSuccess('Compra Detalle deleted successfully');
    }
}
