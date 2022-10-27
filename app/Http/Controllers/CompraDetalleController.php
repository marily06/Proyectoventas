<?php

namespace App\Http\Controllers;

use App\DataTables\CompraDetalleDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateCompraDetalleRequest;
use App\Http\Requests\UpdateCompraDetalleRequest;
use App\Models\CompraDetalle;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CompraDetalleController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Compra Detalles')->only(['show']);
        $this->middleware('permission:Crear Compra Detalles')->only(['create','store']);
        $this->middleware('permission:Editar Compra Detalles')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Compra Detalles')->only(['destroy']);
    }

    /**
     * Display a listing of the CompraDetalle.
     *
     * @param CompraDetalleDataTable $compraDetalleDataTable
     * @return Response
     */
    public function index(CompraDetalleDataTable $compraDetalleDataTable)
    {
        return $compraDetalleDataTable->render('compra_detalles.index');
    }

    /**
     * Show the form for creating a new CompraDetalle.
     *
     * @return Response
     */
    public function create()
    {
        return view('compra_detalles.create');
    }

    /**
     * Store a newly created CompraDetalle in storage.
     *
     * @param CreateCompraDetalleRequest $request
     *
     * @return Response
     */
    public function store(CreateCompraDetalleRequest $request)
    {
        $input = $request->all();

        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::create($input);

        Flash::success('Compra Detalle guardado exitosamente.');

        return redirect(route('compraDetalles.index'));
    }

    /**
     * Display the specified CompraDetalle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            Flash::error('Compra Detalle no encontrado');

            return redirect(route('compraDetalles.index'));
        }

        return view('compra_detalles.show')->with('compraDetalle', $compraDetalle);
    }

    /**
     * Show the form for editing the specified CompraDetalle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            Flash::error('Compra Detalle no encontrado');

            return redirect(route('compraDetalles.index'));
        }

        return view('compra_detalles.edit')->with('compraDetalle', $compraDetalle);
    }

    /**
     * Update the specified CompraDetalle in storage.
     *
     * @param  int              $id
     * @param UpdateCompraDetalleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompraDetalleRequest $request)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            Flash::error('Compra Detalle no encontrado');

            return redirect(route('compraDetalles.index'));
        }

        $compraDetalle->fill($request->all());
        $compraDetalle->save();

        Flash::success('Compra Detalle actualizado con éxito.');

        return redirect(route('compraDetalles.index'));
    }

    /**
     * Remove the specified CompraDetalle from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var CompraDetalle $compraDetalle */
        $compraDetalle = CompraDetalle::find($id);

        if (empty($compraDetalle)) {
            Flash::error('Compra Detalle no encontrado');

            return redirect(route('compraDetalles.index'));
        }

        $compraDetalle->delete();

        Flash::success('Compra Detalle deleted successfully.');

        return redirect(route('compraDetalles.index'));
    }
}
