<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompraEstadoAPIRequest;
use App\Http\Requests\API\UpdateCompraEstadoAPIRequest;
use App\Models\CompraEstado;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CompraEstadoController
 * @package App\Http\Controllers\API
 */

class CompraEstadoAPIController extends AppBaseController
{
    /**
     * Display a listing of the CompraEstado.
     * GET|HEAD /compraEstados
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = CompraEstado::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $compraEstados = $query->get();

        return $this->sendResponse($compraEstados->toArray(), 'Compra Estados retrieved successfully');
    }

    /**
     * Store a newly created CompraEstado in storage.
     * POST /compraEstados
     *
     * @param CreateCompraEstadoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraEstadoAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::create($input);

        return $this->sendResponse($compraEstado->toArray(), 'Compra Estado guardado exitosamente');
    }

    /**
     * Display the specified CompraEstado.
     * GET|HEAD /compraEstados/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            return $this->sendError('Compra Estado no encontrado');
        }

        return $this->sendResponse($compraEstado->toArray(), 'Compra Estado retrieved successfully');
    }

    /**
     * Update the specified CompraEstado in storage.
     * PUT/PATCH /compraEstados/{id}
     *
     * @param int $id
     * @param UpdateCompraEstadoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraEstadoAPIRequest $request)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            return $this->sendError('Compra Estado no encontrado');
        }

        $compraEstado->fill($request->all());
        $compraEstado->save();

        return $this->sendResponse($compraEstado->toArray(), 'CompraEstado actualizado con éxito');
    }

    /**
     * Remove the specified CompraEstado from storage.
     * DELETE /compraEstados/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            return $this->sendError('Compra Estado no encontrado');
        }

        $compraEstado->delete();

        return $this->sendSuccess('Compra Estado deleted successfully');
    }
}
