<?php

namespace App\Http\Controllers;

use App\DataTables\VentaEstadoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateVentaEstadoRequest;
use App\Http\Requests\UpdateVentaEstadoRequest;
use App\Models\VentaEstado;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class VentaEstadoController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver Venta Estados')->only(['show']);
        $this->middleware('permission:Crear Venta Estados')->only(['create','store']);
        $this->middleware('permission:Editar Venta Estados')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Venta Estados')->only(['destroy']);
    }

    /**
     * Display a listing of the VentaEstado.
     *
     * @param VentaEstadoDataTable $ventaEstadoDataTable
     * @return Response
     */
    public function index(VentaEstadoDataTable $ventaEstadoDataTable)
    {
        return $ventaEstadoDataTable->render('venta_estados.index');
    }

    /**
     * Show the form for creating a new VentaEstado.
     *
     * @return Response
     */
    public function create()
    {
        return view('venta_estados.create');
    }

    /**
     * Store a newly created VentaEstado in storage.
     *
     * @param CreateVentaEstadoRequest $request
     *
     * @return Response
     */
    public function store(CreateVentaEstadoRequest $request)
    {
        $input = $request->all();

        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::create($input);

        Flash::success('Venta Estado guardado exitosamente.');

        return redirect(route('ventaEstados.index'));
    }

    /**
     * Display the specified VentaEstado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            Flash::error('Venta Estado no encontrado');

            return redirect(route('ventaEstados.index'));
        }

        return view('venta_estados.show')->with('ventaEstado', $ventaEstado);
    }

    /**
     * Show the form for editing the specified VentaEstado.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            Flash::error('Venta Estado no encontrado');

            return redirect(route('ventaEstados.index'));
        }

        return view('venta_estados.edit')->with('ventaEstado', $ventaEstado);
    }

    /**
     * Update the specified VentaEstado in storage.
     *
     * @param  int              $id
     * @param UpdateVentaEstadoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateVentaEstadoRequest $request)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            Flash::error('Venta Estado no encontrado');

            return redirect(route('ventaEstados.index'));
        }

        $ventaEstado->fill($request->all());
        $ventaEstado->save();

        Flash::success('Venta Estado actualizado con éxito.');

        return redirect(route('ventaEstados.index'));
    }

    /**
     * Remove the specified VentaEstado from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var VentaEstado $ventaEstado */
        $ventaEstado = VentaEstado::find($id);

        if (empty($ventaEstado)) {
            Flash::error('Venta Estado no encontrado');

            return redirect(route('ventaEstados.index'));
        }

        $ventaEstado->delete();

        Flash::success('Venta Estado deleted successfully.');

        return redirect(route('ventaEstados.index'));
    }
}
