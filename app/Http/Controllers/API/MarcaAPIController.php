<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateMarcaAPIRequest;
use App\Http\Requests\API\UpdateMarcaAPIRequest;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class MarcaController
 * @package App\Http\Controllers\API
 */

class MarcaAPIController extends AppBaseController
{
    /**
     * Display a listing of the Marca.
     * GET|HEAD /marcas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = Marca::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $marcas = $query->get();

        return $this->sendResponse($marcas->toArray(), 'Marcas retrieved successfully');
    }

    /**
     * Store a newly created Marca in storage.
     * POST /marcas
     *
     * @param CreateMarcaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateMarcaAPIRequest $request)
    {
        $input = $request->all();

        /** @var Marca $marca */
        $marca = Marca::create($input);

        return $this->sendResponse($marca->toArray(), 'Marca guardado exitosamente');
    }

    /**
     * Display the specified Marca.
     * GET|HEAD /marcas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Marca $marca */
        $marca = Marca::find($id);

        if (empty($marca)) {
            return $this->sendError('Marca no encontrado');
        }

        return $this->sendResponse($marca->toArray(), 'Marca retrieved successfully');
    }

    /**
     * Update the specified Marca in storage.
     * PUT/PATCH /marcas/{id}
     *
     * @param int $id
     * @param UpdateMarcaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarcaAPIRequest $request)
    {
        /** @var Marca $marca */
        $marca = Marca::find($id);

        if (empty($marca)) {
            return $this->sendError('Marca no encontrado');
        }

        $marca->fill($request->all());
        $marca->save();

        return $this->sendResponse($marca->toArray(), 'Marca actualizado con éxito');
    }

    /**
     * Remove the specified Marca from storage.
     * DELETE /marcas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Marca $marca */
        $marca = Marca::find($id);

        if (empty($marca)) {
            return $this->sendError('Marca no encontrado');
        }

        $marca->delete();

        return $this->sendSuccess('Marca deleted successfully');
    }
}
