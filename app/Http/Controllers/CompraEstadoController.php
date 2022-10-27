<?php

namespace App\Http\Controllers;

use App\DataTables\CompraEstadoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCompraEstadoRequest;
use App\Http\Requests\UpdateCompraEstadoRequest;
use App\Models\CompraEstado;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CompraEstadoController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Compra Estados')->only(['show']);
        $this->middleware('permission:Crear Compra Estados')->only(['create','store']);
        $this->middleware('permission:Editar Compra Estados')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Compra Estados')->only(['destroy']);
    }

    /**
     * Display a listing of the CompraEstado.
     *
     * @param CompraEstadoDataTable $compraEstadoDataTable
     * @return Response
     */
    public function index(CompraEstadoDataTable $compraEstadoDataTable)
    {
        return $compraEstadoDataTable->render('compra_estados.index');
    }

    /**
     * Show the form for creating a new CompraEstado.
     *
     * @return Response
     */
    public function create()
    {
        return view('compra_estados.create');
    }

    /**
     * Store a newly created CompraEstado in storage.
     *
     * @param CreateCompraEstadoRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraEstadoRequest $request)
    {
        $input = $request->all();

        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::create($input);

        Flash::success('Compra Estado guardado exitosamente.');

        return redirect(route('compraEstados.index'));
    }

    /**
     * Display the specified CompraEstado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            Flash::error('Compra Estado no encontrado');

            return redirect(route('compraEstados.index'));
        }

        return view('compra_estados.show')->with('compraEstado', $compraEstado);
    }

    /**
     * Show the form for editing the specified CompraEstado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            Flash::error('Compra Estado no encontrado');

            return redirect(route('compraEstados.index'));
        }

        return view('compra_estados.edit')->with('compraEstado', $compraEstado);
    }

    /**
     * Update the specified CompraEstado in storage.
     *
     * @param  int              $id
     * @param UpdateCompraEstadoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraEstadoRequest $request)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            Flash::error('Compra Estado no encontrado');

            return redirect(route('compraEstados.index'));
        }

        $compraEstado->fill($request->all());
        $compraEstado->save();

        Flash::success('Compra Estado actualizado con éxito.');

        return redirect(route('compraEstados.index'));
    }

    /**
     * Remove the specified CompraEstado from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CompraEstado $compraEstado */
        $compraEstado = CompraEstado::find($id);

        if (empty($compraEstado)) {
            Flash::error('Compra Estado no encontrado');

            return redirect(route('compraEstados.index'));
        }

        $compraEstado->delete();

        Flash::success('Compra Estado deleted successfully.');

        return redirect(route('compraEstados.index'));
    }
}
