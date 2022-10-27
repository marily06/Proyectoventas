<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Item;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class HomeController extends AppBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ( ! session()->has('carrito')) {
            session()->put('carrito', new Collection());
            session()->save();
        }

        return view('ecommerce.home');
    }

    public function tienda(Request $request)
    {
        //Se crea la variable de sesión para el carro de compras de no existir
        if ( ! session()->has('carrito')) {
            session()->put('carrito', new Collection());
            session()->save();
        }

        $itemsTop = Item::withCount('ventaDetalles')->get()->sortBy('venta_detalles_count')->take(5);


        $query = Item::with(['media'])->web();

        $categoria = $request->categoria;
        $marca = $request->marca;
        $search = $request->search;

        if($request->categoria){
            $query->deCategoria($request->categoria);
        }


        if($marca){
            $query->deMarca($marca);
        }

        if($search){
            $query->where('nombre','like',"%{$search}%");
        }


        $items = $query->orderBy('created_at','desc')->paginate(9);


//                dd($items->first()->toArray());

        return view('ecommerce.productos',compact('items','categoria','marca','search','itemsTop'));

    }

    public function fichaProducto(Item $item)
    {
        return view('ecommerce.ficha_producto',compact('item'));
    }

    public function panel()
    {
        return view('ecommerce.panel');
    }

    public function perfil()
    {
        return view('ecommerce.perfil');
    }

    public function perfilUpdate(User $user,Request $request)
    {

        $user->fill($request->all());
        $user->save();

        flash('Perfil actualizado con exito')->success();

        return redirect(route('perfil'));
    }


    public function categorias()
    {
        return view('ecommerce.categorias');
    }

    public function marcas()
    {
        return view('ecommerce.marcas');
    }

    public function contact()
    {
        return view('ecommerce.contacto');
    }

    public function contactStore(Request $request)
    {

        try {
            $correo = appIsDebug() ? correoPruebas() : correoSistema();
            Mail::to($correo)->send(new ContactMail());
        }catch (\Exception $exception){

            return $this->sendError('hubo un error intente de nuevo!');

        }

        return $this->sendResponse([],'!Mensaje enviado correctamente!');

    }
}
