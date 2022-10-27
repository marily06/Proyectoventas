<?php

namespace App\Http\Controllers;

use App\DataTables\ItemComentarioDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateItemComentarioRequest;
use App\Http\Requests\UpdateItemComentarioRequest;
use App\Models\ItemComentario;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ItemComentarioController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Item Comentarios')->only(['show']);
        $this->middleware('permission:Crear Item Comentarios')->only(['create','store']);
        $this->middleware('permission:Editar Item Comentarios')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Item Comentarios')->only(['destroy']);
    }

    /**
     * Display a listing of the ItemComentario.
     *
     * @param ItemComentarioDataTable $itemComentarioDataTable
     * @return Response
     */
    public function index(ItemComentarioDataTable $itemComentarioDataTable)
    {
        return $itemComentarioDataTable->render('item_comentarios.index');
    }

    /**
     * Show the form for creating a new ItemComentario.
     *
     * @return Response
     */
    public function create()
    {
        return view('item_comentarios.create');
    }

    /**
     * Store a newly created ItemComentario in storage.
     *
     * @param CreateItemComentarioRequest $request
     *
     * @return Response
     */
    public function store(CreateItemComentarioRequest $request)
    {
        $input = $request->all();

        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::create($input);

        Flash::success('Item Comentario guardado exitosamente.');

        return redirect(route('itemComentarios.index'));
    }

    /**
     * Display the specified ItemComentario.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::find($id);

        if (empty($itemComentario)) {
            Flash::error('Item Comentario no encontrado');

            return redirect(route('itemComentarios.index'));
        }

        return view('item_comentarios.show')->with('itemComentario', $itemComentario);
    }

    /**
     * Show the form for editing the specified ItemComentario.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::find($id);

        if (empty($itemComentario)) {
            Flash::error('Item Comentario no encontrado');

            return redirect(route('itemComentarios.index'));
        }

        return view('item_comentarios.edit')->with('itemComentario', $itemComentario);
    }

    /**
     * Update the specified ItemComentario in storage.
     *
     * @param  int              $id
     * @param UpdateItemComentarioRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemComentarioRequest $request)
    {
        /** @var ItemComentario $itemComentario */
        $itemComentario = ItemComentario::find($id);

        if (empty($itemComentario)) {
            Flash::error('Item Comentario no encontrado');

            return redirect(route('itemComentarios.index'));
        }

        $itemComentario->fill($request->all());
        $itemComentario->save();

        Flash::success('Item Comentario actualizado con éxito.');

        return redirect(route('itemComentarios.index'));
    }

    /**
     * Remove the specified ItemComentario from storage.
     *
     * @param  int $id
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
            Flash::error('Item Comentario no encontrado');

            return redirect(route('itemComentarios.index'));
        }

        $itemComentario->delete();

        Flash::success('Item Comentario deleted successfully.');

        return redirect(route('itemComentarios.index'));
    }
}
