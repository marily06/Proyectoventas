<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompraTipoAPIRequest;
use App\Http\Requests\API\UpdateCompraTipoAPIRequest;
use App\Models\CompraTipo;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CompraTipoController
 * @package App\Http\Controllers\API
 */

class CompraTipoAPIController extends AppBaseController
{
    /**
     * Display a listing of the CompraTipo.
     * GET|HEAD /compraTipos
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = CompraTipo::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $compraTipos = $query->get();

        return $this->sendResponse($compraTipos->toArray(), 'Compra Tipos retrieved successfully');
    }

    /**
     * Store a newly created CompraTipo in storage.
     * POST /compraTipos
     *
     * @param CreateCompraTipoAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraTipoAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::create($input);

        return $this->sendResponse($compraTipo->toArray(), 'Compra Tipo guardado exitosamente');
    }

    /**
     * Display the specified CompraTipo.
     * GET|HEAD /compraTipos/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::find($id);

        if (empty($compraTipo)) {
            return $this->sendError('Compra Tipo no encontrado');
        }

        return $this->sendResponse($compraTipo->toArray(), 'Compra Tipo retrieved successfully');
    }

    /**
     * Update the specified CompraTipo in storage.
     * PUT/PATCH /compraTipos/{id}
     *
     * @param int $id
     * @param UpdateCompraTipoAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraTipoAPIRequest $request)
    {
        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::find($id);

        if (empty($compraTipo)) {
            return $this->sendError('Compra Tipo no encontrado');
        }

        $compraTipo->fill($request->all());
        $compraTipo->save();

        return $this->sendResponse($compraTipo->toArray(), 'CompraTipo actualizado con éxito');
    }

    /**
     * Remove the specified CompraTipo from storage.
     * DELETE /compraTipos/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::find($id);

        if (empty($compraTipo)) {
            return $this->sendError('Compra Tipo no encontrado');
        }

        $compraTipo->delete();

        return $this->sendSuccess('Compra Tipo deleted successfully');
    }
}
