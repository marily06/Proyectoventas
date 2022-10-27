<table border="1" width="85%">
    <thead>
    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
    </tr>
    </thead>
    <tbody>

    @foreach($compra->detalles as $det)
        <tr>
            <td>{{$det->item->nombre}}</td>
            <td>{{nf($det->cantidad)}}</td>
        </tr>

    @endforeach

    </tbody>
    <tfoot>
    <tr>
        <th colspan="5" align="right">Total Artículos  {{nf( $compra->detalles->sum('cantidad') )}}</th>
    </tr>
    </tfoot>
</table>
