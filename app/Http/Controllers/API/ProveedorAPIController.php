<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateProveedorAPIRequest;
use App\Http\Requests\API\UpdateProveedorAPIRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ProveedorController
 * @package App\Http\Controllers\API
 */

class ProveedorAPIController extends AppBaseController
{
    /**
     * Display a listing of the Proveedor.
     * GET|HEAD /proveedors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $proveedors = $query->get();

        return $this->sendResponse($proveedors->toArray(), 'Proveedors retrieved successfully');
    }

    /**
     * Store a newly created Proveedor in storage.
     * POST /proveedors
     *
     * @param CreateProveedorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateProveedorAPIRequest $request)
    {
        $input = $request->all();

        /** @var Proveedor $proveedor */
        $proveedor = Proveedor::create($input);

        return $this->sendResponse($proveedor->toArray(), 'Proveedor guardado exitosamente');
    }

    /**
     * Display the specified Proveedor.
     * GET|HEAD /proveedors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Proveedor $proveedor */
        $proveedor = Proveedor::find($id);

        if (empty($proveedor)) {
            return $this->sendError('Proveedor no encontrado');
        }

        return $this->sendResponse($proveedor->toArray(), 'Proveedor retrieved successfully');
    }

    /**
     * Update the specified Proveedor in storage.
     * PUT/PATCH /proveedors/{id}
     *
     * @param int $id
     * @param UpdateProveedorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProveedorAPIRequest $request)
    {
        /** @var Proveedor $proveedor */
        $proveedor = Proveedor::find($id);

        if (empty($proveedor)) {
            return $this->sendError('Proveedor no encontrado');
        }

        $proveedor->fill($request->all());
        $proveedor->save();

        return $this->sendResponse($proveedor->toArray(), 'Proveedor actualizado con éxito');
    }

    /**
     * Remove the specified Proveedor from storage.
     * DELETE /proveedors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Proveedor $proveedor */
        $proveedor = Proveedor::find($id);

        if (empty($proveedor)) {
            return $this->sendError('Proveedor no encontrado');
        }

        $proveedor->delete();

        return $this->sendSuccess('Proveedor deleted successfully');
    }
}
