<div class="table-responsive">
    <table class="table table-bordered table-hover table-xtra-condensed">
        <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($venta->detalles as $det)
            <tr class="text-sm">
                <td>{{$det->item->nombre}}</td>
                <td class="text-right">{{ dvs() }} {{nfp($det->precio)}}</td>
                <td>{{nf($det->cantidad)}}</td>
                <td class="text-right">{{ dvs() }} {{nfp($det->cantidad*$det->precio)}}</td>
            </tr>
        @endforeach
        <tr class="text-right text-sm">
            <td colspan="3">Total </td>
            <td ><b>{{ dvs() }} {{nfp($venta->total)}}</b></td>
        </tr>
        </tbody>
    </table>
</div>
