<?php

namespace App\Http\Controllers;

use App\DataTables\ItemCategoriaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateItemCategoriaRequest;
use App\Http\Requests\UpdateItemCategoriaRequest;
use App\Models\ItemCategoria;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ItemCategoriaController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Item Categorias')->only(['show']);
        $this->middleware('permission:Crear Item Categorias')->only(['create','store']);
        $this->middleware('permission:Editar Item Categorias')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Item Categorias')->only(['destroy']);
    }

    /**
     * Display a listing of the ItemCategoria.
     *
     * @param ItemCategoriaDataTable $itemCategoriaDataTable
     * @return Response
     */
    public function index(ItemCategoriaDataTable $itemCategoriaDataTable)
    {
        return $itemCategoriaDataTable->render('item_categorias.index');
    }

    /**
     * Show the form for creating a new ItemCategoria.
     *
     * @return Response
     */
    public function create()
    {
        return view('item_categorias.create');
    }

    /**
     * Store a newly created ItemCategoria in storage.
     *
     * @param CreateItemCategoriaRequest $request
     *
     * @return Response
     */
    public function store(CreateItemCategoriaRequest $request)
    {
        $input = $request->all();

        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::create($input);


        if ($request->hasFile('imagen')){

            $itemCategoria->clearMediaCollection('categorias');
            $itemCategoria->addMediaFromRequest('imagen')->toMediaCollection('categorias');
        }

        Flash::success('Item Categoria guardado exitosamente.');

        return redirect(route('itemCategorias.index'));
    }

    /**
     * Display the specified ItemCategoria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::find($id);

        if (empty($itemCategoria)) {
            Flash::error('Item Categoria no encontrado');

            return redirect(route('itemCategorias.index'));
        }

        return view('item_categorias.show')->with('itemCategoria', $itemCategoria);
    }

    /**
     * Show the form for editing the specified ItemCategoria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::find($id);

        if (empty($itemCategoria)) {
            Flash::error('Item Categoria no encontrado');

            return redirect(route('itemCategorias.index'));
        }

        return view('item_categorias.edit')->with('itemCategoria', $itemCategoria);
    }

    /**
     * Update the specified ItemCategoria in storage.
     *
     * @param  int              $id
     * @param UpdateItemCategoriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemCategoriaRequest $request)
    {
        /** @var ItemCategoria $itemCategoria */
        $itemCategoria = ItemCategoria::find($id);

        if (empty($itemCategoria)) {
            Flash::error('Item Categoria no encontrado');

            return redirect(route('itemCategorias.index'));
        }

        $itemCategoria->fill($request->all());
        $itemCategoria->save();


        if ($request->hasFile('imagen')){

            $itemCategoria->clearMediaCollection('categorias');
            $itemCategoria->addMediaFromRequest('imagen')->toMediaCollection('categorias');
        }

        Flash::success('Item Categoria actualizado con éxito.');

        return redirect(route('itemCategorias.index'));
    }

    /**
     * Remove the specified ItemCategoria from storage.
     *
     * @param  int $id
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
            Flash::error('Item Categoria no encontrado');

            return redirect(route('itemCategorias.index'));
        }

        $itemCategoria->delete();

        Flash::success('Item Categoria deleted successfully.');

        return redirect(route('itemCategorias.index'));
    }
}
