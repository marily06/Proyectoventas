<?php


namespace App\Traits;


use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\Request;

trait ItemTrait
{


    public function procesarStore(Request $request)
    {

        $categorias = $request->categorias ?? [];

        $request->merge([
            'web' => 1,
            'icategoria_id' => $categorias[0] ?? null,
        ]);

        /**
         * @var Item $item
         */
        $item = Item::create($request->all());

        if ($request->hasFile('imagen')){
            $item->addMediaFromRequest('imagen')->toMediaCollection('items');
        }

        $item->categorias()->sync($categorias);

        $item->load('marca','unimed');

        return $item;
    }

    public function processUpdate(UpdateItemRequest $request,Item $item)
    {

        //Categorías multiples para el item
        $categorias = $request->categorias ?? [];
        //Categoría principal (si se selecciona al menos una categoría; la categoría principal es la primera del array)
        $request->merge([
            'web' => 1,
            'icategoria_id' => $categorias[0] ?? null
        ]);


        if ($request->hasFile('imagen')){
            $item->addMediaFromRequest('imagen')->toMediaCollection('items');
        }

        /**
         * @var Item $item
         */
        $item->fill($request->all());
        $item->save();


        //Sincroniza las categorías
        $item->categorias()->sync($categorias);


        $item->load('marca','unimed');

        return $item;
    }
}
