<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItemCategoriaAPIRequest;
use App\Http\Requests\API\UpdateItemCategoriaAPIRequest;
use App\Models\ItemCategoria;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ItemCategoriaController
 * @package App\Http\Controllers\API
 */

class ItemCategoriaAPIController extends AppBaseController
{
    /**
     * Display a listing of the ItemCategoria.
     * GET|HEAD /itemCategorias
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $query = ItemCategoria::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $itemCategorias = $query->get();

        return $this->sendResponse($itemCategorias->toArray(), 'Item Categorias retrieved successfully');
    }

    /**
     * Store a newly created ItemCategoria in storage.
     * POST /itemCategorias
     *
     * @param CreateItemCategoriaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateItemCategoriaAPIRequest $request)
    {
        $input = $request->all();

        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::create($input);

        return $this->sendResponse($itemCategoria->toArray(), 'Item Categoria guardado exitosamente');
    }

    /**
     * Display the specified ItemCategoria.
     * GET|HEAD /itemCategorias/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::find($id);

        if (empty($itemCategoria)) {
            return $this->sendError('Item Categoria no encontrado');
        }

        return $this->sendResponse($itemCategoria->toArray(), 'Item Categoria retrieved successfully');
    }

    /**
     * Update the specified ItemCategoria in storage.
     * PUT/PATCH /itemCategorias/{id}
     *
     * @param int $id
     * @param UpdateItemCategoriaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemCategoriaAPIRequest $request)
    {
        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::find($id);

        if (empty($itemCategoria)) {
            return $this->sendError('Item Categoria no encontrado');
        }

        $itemCategoria->fill($request->all());
        $itemCategoria->save();

        return $this->sendResponse($itemCategoria->toArray(), 'ItemCategoria actualizado con éxito');
    }

    /**
     * Remove the specified ItemCategoria from storage.
     * DELETE /itemCategorias/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::find($id);

        if (empty($itemCategoria)) {
            return $this->sendError('Item Categoria no encontrado');
        }

        $itemCategoria->delete();

        return $this->sendSuccess('Item Categoria deleted successfully');
    }
}
