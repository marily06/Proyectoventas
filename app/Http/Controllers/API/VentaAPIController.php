<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateVentaAPIRequest;
use App\Http\Requests\API\UpdateVentaAPIRequest;
use App\Models\Venta;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class VentaController
 * @package App\Http\Controllers\API
 */

class VentaAPIController extends AppBaseController
{
    /**
     * Display a listing of the Venta.
     * GET|HEAD /ventas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Venta::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $ventas = $query->get();

        return $this->sendResponse($ventas->toArray(), 'Ventas retrieved successfully');
    }

    /**
     * Store a newly created Venta in storage.
     * POST /ventas
     *
     * @param CreateVentaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateVentaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Venta $venta */
        $venta = Venta::create($input);

        return $this->sendResponse($venta->toArray(), 'Venta guardado exitosamente');
    }

    /**
     * Display the specified Venta.
     * GET|HEAD /ventas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Venta $venta */
        $venta = Venta::find($id);

        if (empty($venta)) {
            return $this->sendError('Venta no encontrado');
        }

        return $this->sendResponse($venta->toArray(), 'Venta retrieved successfully');
    }

    /**
     * Update the specified Venta in storage.
     * PUT/PATCH /ventas/{id}
     *
     * @param int $id
     * @param UpdateVentaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVentaAPIRequest $request)
    {
        /** @var Venta $venta */
        $venta = Venta::find($id);

        if (empty($venta)) {
            return $this->sendError('Venta no encontrado');
        }

        $venta->fill($request->all());
        $venta->save();

        return $this->sendResponse($venta->toArray(), 'Venta actualizado con éxito');
    }

    /**
     * Remove the specified Venta from storage.
     * DELETE /ventas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Venta $venta */
        $venta = Venta::find($id);

        if (empty($venta)) {
            return $this->sendError('Venta no encontrado');
        }

        $venta->delete();

        return $this->sendSuccess('Venta deleted successfully');
    }
}
