<span>
    {{$venta->id}}
</span>
<div class="modal fade" id="modal-detalles-{{$venta->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="font-size: 14px">
                        @include('ventas.show_fields',['venta'=> $venta])
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include('ventas.tabla_detalles2',['venta'=> $venta])
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 float-right">

                    </div>
                </div>

            </div>
            {{--<div class="modal-footer">--}}
            {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
            {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
            {{--</div>--}}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
