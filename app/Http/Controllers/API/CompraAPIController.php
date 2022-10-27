<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompraAPIRequest;
use App\Http\Requests\API\UpdateCompraAPIRequest;
use App\Models\Compra;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CompraController
 * @package App\Http\Controllers\API
 */

class CompraAPIController extends AppBaseController
{
    /**
     * Display a listing of the Compra.
     * GET|HEAD /compras
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Compra::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $compras = $query->get();

        return $this->sendResponse($compras->toArray(), 'Compras retrieved successfully');
    }

    /**
     * Store a newly created Compra in storage.
     * POST /compras
     *
     * @param CreateCompraAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraAPIRequest $request)
    {
        $input = $request->all();

        /** @var Compra $compra */
        $compra = Compra::create($input);

        return $this->sendResponse($compra->toArray(), 'Compra guardado exitosamente');
    }

    /**
     * Display the specified Compra.
     * GET|HEAD /compras/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            return $this->sendError('Compra no encontrado');
        }

        return $this->sendResponse($compra->toArray(), 'Compra retrieved successfully');
    }

    /**
     * Update the specified Compra in storage.
     * PUT/PATCH /compras/{id}
     *
     * @param int $id
     * @param UpdateCompraAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraAPIRequest $request)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            return $this->sendError('Compra no encontrado');
        }

        $compra->fill($request->all());
        $compra->save();

        return $this->sendResponse($compra->toArray(), 'Compra actualizado con éxito');
    }

    /**
     * Remove the specified Compra from storage.
     * DELETE /compras/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Compra $compra */
        $compra = Compra::find($id);

        if (empty($compra)) {
            return $this->sendError('Compra no encontrado');
        }

        $compra->delete();

        return $this->sendSuccess('Compra deleted successfully');
    }
}
