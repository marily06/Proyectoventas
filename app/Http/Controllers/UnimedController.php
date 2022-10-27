<?php

namespace App\Http\Controllers;

use App\DataTables\UnimedDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUnimedRequest;
use App\Http\Requests\UpdateUnimedRequest;
use App\Models\Unimed;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UnimedController extends AppBaseController
{

    public function __construct()
    {
        $this->middleware('permission:Ver unidades medida')->only(['show']);
        $this->middleware('permission:Crear unidades medida')->only(['create','store']);
        $this->middleware('permission:Editar unidades medida')->only(['edit','update',]);
        $this->middleware('permission:Eliminar unidades medida')->only(['destroy']);
    }

    /**
     * Display a listing of the Unimed.
     *
     * @param UnimedDataTable $unimedDataTable
     * @return Response
     */
    public function index(UnimedDataTable $unimedDataTable)
    {
        return $unimedDataTable->render('unimeds.index');
    }

    /**
     * Show the form for creating a new Unimed.
     *
     * @return Response
     */
    public function create()
    {
        return view('unimeds.create');
    }

    /**
     * Store a newly created Unimed in storage.
     *
     * @param CreateUnimedRequest $request
     *
     * @return Response
     */
    public function store(CreateUnimedRequest $request)
    {
        $input = $request->all();

        /** @var Unimed $unimed */
        $unimed = Unimed::create($input);

        Flash::success('Unimed guardado exitosamente.');

        return redirect(route('unimeds.index'));
    }

    /**
     * Display the specified Unimed.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            Flash::error('Unimed no encontrado');

            return redirect(route('unimeds.index'));
        }

        return view('unimeds.show')->with('unimed', $unimed);
    }

    /**
     * Show the form for editing the specified Unimed.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            Flash::error('Unimed no encontrado');

            return redirect(route('unimeds.index'));
        }

        return view('unimeds.edit')->with('unimed', $unimed);
    }

    /**
     * Update the specified Unimed in storage.
     *
     * @param  int              $id
     * @param UpdateUnimedRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUnimedRequest $request)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            Flash::error('Unimed no encontrado');

            return redirect(route('unimeds.index'));
        }

        $unimed->fill($request->all());
        $unimed->save();

        Flash::success('Unimed actualizado con éxito.');

        return redirect(route('unimeds.index'));
    }

    /**
     * Remove the specified Unimed from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Unimed $unimed */
        $unimed = Unimed::find($id);

        if (empty($unimed)) {
            Flash::error('Unimed no encontrado');

            return redirect(route('unimeds.index'));
        }

        $unimed->delete();

        Flash::success('Unimed deleted successfully.');

        return redirect(route('unimeds.index'));
    }
}
