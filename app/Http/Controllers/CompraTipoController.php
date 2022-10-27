<?php

namespace App\Http\Controllers;

use App\DataTables\CompraTipoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCompraTipoRequest;
use App\Http\Requests\UpdateCompraTipoRequest;
use App\Models\CompraTipo;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CompraTipoController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Compra Tipos')->only(['show']);
        $this->middleware('permission:Crear Compra Tipos')->only(['create','store']);
        $this->middleware('permission:Editar Compra Tipos')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Compra Tipos')->only(['destroy']);
    }

    /**
     * Display a listing of the CompraTipo.
     *
     * @param CompraTipoDataTable $compraTipoDataTable
     * @return Response
     */
    public function index(CompraTipoDataTable $compraTipoDataTable)
    {
        return $compraTipoDataTable->render('compra_tipos.index');
    }

    /**
     * Show the form for creating a new CompraTipo.
     *
     * @return Response
     */
    public function create()
    {
        return view('compra_tipos.create');
    }

    /**
     * Store a newly created CompraTipo in storage.
     *
     * @param CreateCompraTipoRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraTipoRequest $request)
    {
        $input = $request->all();

        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::create($input);

        Flash::success('Compra Tipo guardado exitosamente.');

        return redirect(route('compraTipos.index'));
    }

    /**
     * Display the specified CompraTipo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::find($id);

        if (empty($compraTipo)) {
            Flash::error('Compra Tipo no encontrado');

            return redirect(route('compraTipos.index'));
        }

        return view('compra_tipos.show')->with('compraTipo', $compraTipo);
    }

    /**
     * Show the form for editing the specified CompraTipo.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::find($id);

        if (empty($compraTipo)) {
            Flash::error('Compra Tipo no encontrado');

            return redirect(route('compraTipos.index'));
        }

        return view('compra_tipos.edit')->with('compraTipo', $compraTipo);
    }

    /**
     * Update the specified CompraTipo in storage.
     *
     * @param  int              $id
     * @param UpdateCompraTipoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraTipoRequest $request)
    {
        /** @var CompraTipo $compraTipo */
        $compraTipo = CompraTipo::find($id);

        if (empty($compraTipo)) {
            Flash::error('Compra Tipo no encontrado');

            return redirect(route('compraTipos.index'));
        }

        $compraTipo->fill($request->all());
        $compraTipo->save();

        Flash::success('Compra Tipo actualizado con éxito.');

        return redirect(route('compraTipos.index'));
    }

    /**
     * Remove the specified CompraTipo from storage.
     *
     * @param  int $id
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
            Flash::error('Compra Tipo no encontrado');

            return redirect(route('compraTipos.index'));
        }

        $compraTipo->delete();

        Flash::success('Compra Tipo deleted successfully.');

        return redirect(route('compraTipos.index'));
    }
}
