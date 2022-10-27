 {{--<a href="{{ route('compras.show', $compra->id) }}" class='btn btn-info btn-xs' data-toggle="tooltip" title="Detalles">--}}
    <span data-toggle="tooltip" title="Ver detalles">
        <a href="#modal-detalles-{{$compra->id}}" data-keyboard="true" data-toggle="modal" class='btn btn-info btn-xs' >
            <i class="fa fa-eye"></i>
        </a>
    </span>

{{--     <a href="{{route('compra.pdf',$compra->id)}}" target="_blank" class='btn btn-outline-success btn-xs' data-toggle="tooltip" title="Imprimir Orden de Compra">--}}
{{--         <i class="fas fa-print"></i>--}}
{{--     </a>--}}

    @can('Anular ingreso de compra')
        @if($compra->estado_id != \App\Models\CompraEstado::ANULADA && $compra->estado_id == \App\Models\CompraEstado::RECIBIDA )
            <a href="#" onclick="deleteItemDt(this)" data-id="{{$compra->id}}" data-toggle="tooltip" title="Anular Ingreso" class='btn btn-outline-danger btn-xs'>
                <i class="fa fa-undo-alt"></i>
            </a>


            <form action="{{ route('compras.anular', $compra->id)}}" method="POST" id="delete-form{{$compra->id}}">
                @method('POST')
                @csrf
            </form>
        @endif
    @endcan

    @can('Cancelar solicitud de compra')
        @if($compra->estado_id == \App\Models\CompraEstado::CREADA )
            {{--<a href="#modal-delete-{{$compra->id}}" data-toggle="modal" class='btn btn-danger btn-xs'>--}}
                {{--<i class="far fa-trash-alt" data-toggle="tooltip" title="Eliminar Solicitud de Compra"></i>--}}
            {{--</a>--}}
            <span data-toggle="tooltip" title="Cancelar Solicitud de Compra">
            <a href="#modal-delete-{{$compra->id}}" data-toggle="modal" class='btn btn-warning btn-xs'>
                <i class="fas fa-ban" ></i>
            </a>
            </span>
        @endif
    @endcan




    <div class="modal fade" id="modal-detalles-{{$compra->id}}" tabindex='-1'>
        <div class="modal-dialog modal-lg">
            <div class="modal-content " style="color: #0A0A0A">
                <div class="modal-header">
                    <h5 class="modal-title">Detalles del ingreso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-sm">
                            @include('compras.show_fields',['compra'=>$compra])
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('compras.tabla_detalles',['compra'=>$compra])
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    @if($compra->estado_id == \App\Models\CompraEstado::CREADA)
                        <a href="{{route('compra.ingreso', $compra->id)}}" ><div class="btn btn-outline-success" >Ingresar</div></a>
                    @else
                        <h4><span class="badge badge-info">{{ $compra->estado->nombre}}</span></h4>
                    @endif

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
