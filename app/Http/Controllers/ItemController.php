<?php

namespace App\Http\Controllers;

use App\DataTables\ItemDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Imports\ItemsImport;
use App\Models\Item;
use App\Models\User;
use App\Traits\ItemTrait;
use Exception;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Validators\ValidationException;
use Response;

class ItemController extends AppBaseController
{
    use ItemTrait;

    public function __construct()
    {
        $this->middleware('permission:Ver Artículos')->only(['show']);
        $this->middleware('permission:Crear Artículos')->only(['create','store']);
        $this->middleware('permission:Editar Artículos')->only(['edit','update',]);
        $this->middleware('permission:Eliminar Artículos')->only(['destroy']);
    }

    /**
     * Display a listing of the Item.
     *
     * @param ItemDataTable $itemDataTable
     * @return Response
     */
    public function index(ItemDataTable $itemDataTable)
    {
        return $itemDataTable->render('items.index');
    }

    /**
     * Show the form for creating a new Item.
     *
     * @return Response
     */
    public function create()
    {
        $item = new Item();

        return view('items.create',compact('item'));
    }

    /**
     * Store a newly created Item in storage.
     *
     * @param CreateItemRequest $request
     *
     * @return Response
     */
    public function store(CreateItemRequest $request)
    {

        /**
         * @var User $user
         */
        $user = auth()->user();

        try {
            DB::beginTransaction();

            $this->procesarStore($request);

        } catch (\Exception $exception) {
            DB::rollBack();

            errorException($exception);

            return redirect()->back();
        }


        DB::commit();

        flash('Item guardado exitosamente.')->success();

        return redirect(route('items.index'));
    }

    /**
     * Display the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item no encontrado');

            return redirect(route('items.index'));
        }

        return view('items.show')->with('item', $item);
    }

    /**
     * Show the form for editing the specified Item.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item no encontrado');

            return redirect(route('items.index'));
        }

        return view('items.edit')->with('item', $item);
    }

    /**
     * Update the specified Item in storage.
     *
     * @param  int              $id
     * @param UpdateItemRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateItemRequest $request)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item no encontrado');

            return redirect(route('items.index'));
        }

        try {
            DB::beginTransaction();

            $this->processUpdate($request,$item);

        } catch (\Exception $exception) {
            DB::rollBack();

            errorException($exception);

            return redirect()->back();
        }


        DB::commit();

        Flash::success('Item actualizado con éxito.');

        return redirect(route('items.index'));
    }

    /**
     * Remove the specified Item from storage.
     *
     * @param  int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Item $item */
        $item = Item::find($id);

        if (empty($item)) {
            Flash::error('Item no encontrado');

            return redirect(route('items.index'));
        }

        $item->delete();

        Flash::success('Item deleted successfully.');

        return redirect(route('items.index'));
    }

    public function importar()
    {

        return view('items.import');

    }

    public function importarStore(Request $request)
    {



        try {

            DB::beginTransaction();


            $import = new ItemsImport();


            $import->import($request->file('file'));



            $codigosExistentes = $import->getCodigosExistentes();


        }
        catch (ValidationException $e) {
            DB::rollBack();
            $erros = array();
            foreach ($e->failures() as $failure) {
                $erros[] = "Error en fila ".$failure->row().": ".implode($failure->errors());
            }

            flash('error', 'Ocurrio un error al intentar importar los datos!')->error();

            return redirect()->back()->withErrors(['REVISA EL ENCABEZADO Y/O PIE DEL ARCHIVO.', 'Ocurrio un error en los datos y/o la estructura del archivo.', $erros]);
        }
        catch (Exception $e){


            DB::rollBack();

            throw $e;

            return redirect()->back()->withErrors(['ERROR AL TRATAR DE LEER EL ARCHIVO.','REVISA QUE EL ARCHIVO TENGA EL FORMATO CORRECTO.']);
        }

        DB::commit();



        if ($codigosExistentes->count() > 0){
            flash('error', 'Ocurrio un error al intentar importar los datos!')->error();


            $codigosExistentes->prepend('NO SE INSERTARON LOS SIGUIENTES REGISTROS PORQUE YA EXISTE EL CÓDIGO');

            return redirect()->back()->withErrors($codigosExistentes->toArray());
        }


        flash('Datos Importados con Exito!')->success();

        return redirect(route('items.importar'));

    }
}
