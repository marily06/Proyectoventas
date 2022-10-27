<span data-toggle="tooltip" title="Click para ver el detalle de stock">
    <a data-toggle="modal" href="#detStock{{$item->id}}">{{nf($item->stocks->sum('cantidad'))}}</a>
</span>
<div class="modal fade" id="detStock{{$item->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle de stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover">
                    <thead class="bg-gray">
                    <tr>
                        <th>Tienda</th>
                        <th>Lote</th>
                        <th>Fecha Vence</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($item->stocks as $st)
                        <tr>
                            <th>{{$st->tienda->nombre}}</th>
                            <th>{{$st->lote}}</th>
                            <th>{{fecha($st->fecha_ven)}}</th>
                            <th>{{nf($st->cantidad)}}</th>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->