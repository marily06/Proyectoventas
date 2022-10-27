<div class="invoice p-3 mb-3" >
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <h4>
                <i class="fas fa-globe"></i> {{config('app.nombre_negocio')}}.
                <small class="float-right">{{__('Date')}}: {{hoy()}}</small>
            </h4>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            {{__('From')}}
            <address>
                <strong>{{config('app.name')}}</strong><br>
                {{config('app.dire_negocio')}}<br>
                {{__('Phone')}}: {{getPbx()}}<br>
                {{__('Email')}}: {{getCorreoNegocio()}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            {{__('To')}}
            <address>
                <strong>{{$venta->cliente->nombre_completo}}</strong><br>
                {{$venta->cliente->direccion}}<br>
                {{__('Phone')}}: {{$venta->cliente->telefono}}<br>
                {{__('Email')}}: {{$venta->cliente->email}}
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Pedido #{{$venta->id}}</b><br>
            <br>
            <b>{{__('Payment Due')}}:</b> {{$venta->created_at->format('d/m/Y')}}<br>
            {{--                                <b>Account:</b> 968-34567--}}
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>cantidad</th>
                    <th>Product</th>
                    <th>Serial #</th>
                    <th>Precio U.</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                @foreach($venta->detalles as $det)
                    <tr class="text-sm">
                        <td>{{nf($det->cantidad)}}</td>
                        <td>{{$det->item->nombre}}</td>
                        <td>{{$det->item->codigo}}</td>
                        <td class="text-right">{{ dvs() }} {{nfp($det->precio)}}</td>
                        <td class="text-right">{{ dvs() }} {{nfp($det->sub_total)}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->

        <div class="col-6">

        </div>
        <!-- /.col -->
        <div class="col-6">

            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{ dvs() }} {{nfp($venta->sub_total)}}</td>
                    </tr>
                    <tr>
                        <th>{{__('Shipping')}}:</th>
                        <td>{{ dvs() }} {{nfp($venta->monto_delivery)}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td><strong>{{ dvs() }} {{nfp($venta->total)}}</strong> </td>
                    </tr>
                </table>
            </div>

            <!-- this row will not appear when printing -->
            @if(routeIs('carrito.exito'))
                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{route('carrito.imprime.factura',$venta->id)}}" target="_blank"  class="btn btn-outline-info float-end" >
                            <i class="fas fa-print"></i> {{__('Print')}}
                        </a>
                    </div>
                </div>
            @endif
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->


</div>
