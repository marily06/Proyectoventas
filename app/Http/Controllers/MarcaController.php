<?php

namespace App\Http\Controllers;

use App\DataTables\MarcaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Marca;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MarcaController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Marcas')->only(['show']);
        $this->middleware('permission:Crear Marcas')->only(['create','store']);
        $this->middleware('permission:Editar Marcas')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Marcas')->only(['destroy']);
    }

    /**
     * Display a listing of the Marca.
     *
     * @param MarcaDataTable $marcaDataTable
     * @return Response
     */
    public function index(MarcaDataTable $marcaDataTable)
    {
        return $marcaDataTable->render('marcas.index');
    }

    /**
     * Show the form for creating a new Marca.
     *
     * @return Response
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Store a newly created Marca in storage.
     *
     * @param CreateMarcaRequest $request
     *
     * @return Response
     */
    public function store(CreateMarcaRequest $request)
    {
        $input = $request->all();

        /** @var Marca $marca */
        $marca = Marca::create($input);


        if ($request->hasFile('imagen')){
            $marca->clearMediaCollection('maracas');
            $marca->addMediaFromRequest('imagen')->toMediaCollection('marcas');
        }

        Flash::success('Marca guardado exitosamente.');

        return redirect(route('marcas.index'));
    }

    /**
     * Display the specified Marca.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Marca $marca */
        $marca = Marca::find($id);

        if (empty($marca)) {
            Flash::error('Marca no encontrado');

            return redirect(route('marcas.index'));
        }

        return view('marcas.show')->with('marca', $marca);
    }

    /**
     * Show the form for editing the specified Marca.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Marca $marca */
        $marca = Marca::find($id);

        if (empty($marca)) {
            Flash::error('Marca no encontrado');

            return redirect(route('marcas.index'));
        }

        return view('marcas.edit')->with('marca', $marca);
    }

    /**
     * Update the specified Marca in storage.
     *
     * @param  int              $id
     * @param UpdateMarcaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMarcaRequest $request)
    {
        /** @var Marca $marca */
        $marca = Marca::find($id);

        if (empty($marca)) {
            Flash::error('Marca no encontrado');

            return redirect(route('marcas.index'));
        }

        $marca->fill($request->all());
        $marca->save();



        if ($request->hasFile('imagen')){
            $marca->clearMediaCollection('marcas');
            $marca->addMediaFromRequest('imagen')->toMediaCollection('marcas');
        }

        Flash::success('Marca actualizado con éxito.');

        return redirect(route('marcas.index'));
    }

    /**
     * Remove the specified Marca from storage.
     *
     * @param  int $id
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
            Flash::error('Marca no encontrado');

            return redirect(route('marcas.index'));
        }

        $marca->delete();

        Flash::success('Marca deleted successfully.');

        return redirect(route('marcas.index'));
    }
}
