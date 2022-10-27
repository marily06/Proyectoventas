<table class="table table-bordered table-hover table-xtra-condensed">
    <thead>
    <tr>
        <th class="text-center">Producto</th>
        <th class="text-center">Precio</th>
        <th class="text-center">Cantidad</th>
        <th class="text-center">Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($venta->detalles as $det)
        <tr class="text-sm">
            <td width="61%">{{$det->item->nombre}}</td>
            <td width="13%" class="text-right">{{ dvs() }} {{nfp($det->precio)}}</td>
            <td width="13%" class="text-right">{{nf($det->cantidad)}}</td>
            <td width="13%" class="text-right">{{ dvs() }} {{nfp($det->cantidad*$det->precio)}}</td>
        </tr>
    @endforeach

    <tr class="text-right text-sm">
        <td colspan="3">Sub Total </td>
        <td ><b>{{ dvs() }} {{nfp($venta->sub_total)}}</b></td>
    </tr>

    <tr class="text-right text-sm">
        <td colspan="3">Descuento </td>
        <td ><b>{{ dvs() }} {{nfp($venta->descuento_monto)}}</b></td>
    </tr>

    <tr class="text-right text-sm">
        <td colspan="3">Envío </td>
        <td ><b>{{ dvs() }} {{nfp($venta->monto_delivery)}}</b></td>
    </tr>
    <tr class="text-right text-sm">
        <td colspan="3">Total </td>
        <td ><b>{{ dvs() }} {{nfp($venta->total)}}</b></td>
    </tr>
</table>

<h4>
    <span class="badge badge-success">Recibido {{ dvs() }} {{nfp($venta->recibido)}}</span>
    <span class="badge badge-secondary">Vuelto {{ dvs() }} {{nfp($venta->vuelto)}}</span>
</h4>
