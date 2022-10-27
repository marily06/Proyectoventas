<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItemComentarioAPIRequest;
use App\Http\Requests\API\UpdateItemComentarioAPIRequest;
use App\Models\ItemComentario;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ItemComentarioController
 * @package App\Http\Controllers\API
 */

class ItemComentarioAPIController extends AppBaseController
{
    /**
     * Display a listing of the ItemComentario.
     * GET|HEAD /itemComentarios
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ItemComentario::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $itemComentarios = $query->get();

        return $this->sendResponse($itemComentarios->toArray(), 'Item Comentarios retrieved successfully');
    }

    /**
     * Store a newly created ItemComentario in storage.
     * POST /itemComentarios
     *
     * @param CreateItemComentarioAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateItemComentarioAPIRequest $request)
    {
        $input = $request->all();

        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::create($input);

        return $this->sendResponse($itemComentario->toArray(), 'Item Comentario guardado exitosamente');
    }

    /**
     * Display the specified ItemComentario.
     * GET|HEAD /itemComentarios/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::find($id);

        if (empty($itemComentario)) {
            return $this->sendError('Item Comentario no encontrado');
        }

        return $this->sendResponse($itemComentario->toArray(), 'Item Comentario retrieved successfully');
    }

    /**
     * Update the specified ItemComentario in storage.
     * PUT/PATCH /itemComentarios/{id}
     *
     * @param int $id
     * @param UpdateItemComentarioAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemComentarioAPIRequest $request)
    {
        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::find($id);

        if (empty($itemComentario)) {
            return $this->sendError('Item Comentario no encontrado');
        }

        $itemComentario->fill($request->all());
        $itemComentario->save();

        return $this->sendResponse($itemComentario->toArray(), 'ItemComentario actualizado con éxito');
    }

    /**
     * Remove the specified ItemComentario from storage.
     * DELETE /itemComentarios/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::find($id);

        if (empty($itemComentario)) {
            return $this->sendError('Item Comentario no encontrado');
        }

        $itemComentario->delete();

        return $this->sendSuccess('Item Comentario deleted successfully');
    }
}
