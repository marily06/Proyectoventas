<table class="table table-bordered table-hover table-xtra-condensed">
    <thead>
    <tr  class="text-center">
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Fecha V</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tbody>
    @foreach($compra->detalles as $det)
        <tr >
            <td>{{$det->item->nombre}}</td>
            <td class="text-right">{{dvs().nf($det->precio)}}</td>
            <td class="text-right">{{nf($det->cantidad)}}</td>
            <td class="text-right">{{fecha($det->fecha_ven)}}</td>
            <td class="text-right">{{dvs().nf($det->cantidad*$det->precio)}}</td>
        </tr>
    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <th colspan="4">Sub Total</th>
        <th class="text-right">
            {{dvs().nf($compra->sub_total)}}
        </th>
    </tr>

{{--    <tr>--}}
{{--        <th colspan="4">Descuento</th>--}}
{{--        <th class="text-right text-success">--}}
{{--            {{dvs().nf($compra->descuento_monto)}}--}}
{{--        </th>--}}
{{--    </tr>--}}

    <tr>
        <th colspan="4">Total</th>
        <th class="text-right">
            {{dvs().nf($compra->total)}}
        </th>
    </tr>
    </tfoot>
</table>
