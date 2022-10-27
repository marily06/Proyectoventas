
    {{--<a href="{{ route('ventas.show', $id) }}" class='btn btn-info btn-xs' data-toggle="tooltip" title="Ver detalles">--}}
    <a href="{{route('ventas.abonar',$venta->id)}}" class='btn btn-info btn-xs' data-toggle="tooltip" title="Ver detalles">
        <i class="fa fa-eye"></i>
    </a>

    {{--  si no se a anulado  --}}
    @if($venta->estado->id!=\App\Models\VentaEstado::ANULADA)
        @can('Anular venta')
            <a href="#" onclick="deleteItemDt(this)" data-id="{{$venta->id}}" data-toggle="tooltip" title="Anular Venta" class='btn btn-outline-danger btn-xs'>
                <i class="fa fa-undo-alt"></i>
            </a>


            <form action="{{ route('ventas.anular', $venta->id)}}" method="POST" id="delete-form{{$venta->id}}">
                @method('POST')
                @csrf
            </form>
        @endcan
    @endif
