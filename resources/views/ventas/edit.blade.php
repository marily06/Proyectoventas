@extends('layouts.app')

@section('title_page')
    Crear Venta
@endsection


@include('layouts.plugins.select2')
@include('layouts.xtra_condensed_css')
@include('layouts.plugins.bootstrap_datetimepicker')
@include('layouts.plugins.fancy_box')
@include('layouts.plugins.sweetalert2')

@push('css')
<style>
    .select2-dropdown {
        z-index: 1039;
    }
</style>
@endpush

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">Editar Venta # {{$venta->id}}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>


    <!-- Main content -->
    <div class="content" id="root">
        <div class="container-fluid ">

            @include('layouts.errores')
            {!! Form::model($venta, ['route' => ['ventas.update', $venta->id], 'method' => 'patch']) !!}
            <div class="row">

                <!--Artículos-->
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="card card-info">
                        <div class="card-header with-border">
                            <h3 class="card-title">
                                <strong>Artículos</strong>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            @include('ventas.tabla_detalles')
                        </div>

                    </div>
                </div>
                <!--Artículos-->

                <!--Resumen-->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                    <div class="card card-info card-solid">
                        <div class="card-header with-border">
                            <h3 class="card-title">
                                <strong>
                                    VENTA <small> iniciada: {{fechaHoraLtn($venta->created_at)}}</small>
                                </strong>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="padding: 0px;">


                            @include('ventas.fields_edit')


                        </div>
                    </div><!-- /.row -->

                </div>
                <!--/Resumen-->

            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /.content -->

    @include('clientes.modal_form')


@endsection
@push('scripts')
<!--    Scripts ventas
------------------------------------------------->
<script >

    vm = new Vue({
        el: '#root',
        mounted: function() {
            this.getDets();
        },
        data: {
            venta_id : '{{$venta->id}}',
            detalles: [],
            credito: $.parseJSON('{{$venta->credito ? 'true' : 'false'}}'),
            abono_ini: null,
            detalleEdita: {
                id: '',
                temp_venta_id: '',
                item_id: '',
                cantidad: '',
                precio: '',
            },
            idEditando: '',
            recibido: '{{$venta->recibido}}',
            clienteVenta: '{{$venta->cliente_id}}',
            delivery: $.parseJSON('{{$venta->delivery ? 'true' : 'false'}}'),
            abono_delivery: '{{$venta->monto_delivery}}',
            programa_entrega: $.parseJSON('{{$venta->fecha_entrega ? 'true' : 'false'}}'),
        },
        methods: {
            numf: function(numero){
                return nfp(numero)
            },
            getDets: function(page) {
                var url = '{{route('api.venta_detalles.index')}}';
                var params = {params: { venta_id: this.venta_id}};
                axios.get(url,params).then(response => {
                    this.detalles = response.data.data;
                });
            },
        },
        computed: {
            total: function () {
                var t=0;
                var monto_delivery = parseFloat(this.abono_delivery);
                var monto_delivery = isNaN(monto_delivery) ? 0 : monto_delivery;
                $.each(this.detalles,function (i,det) {
                    t+=(det.cantidad*det.precio);
                });

                if(t>0 && this.delivery){
                    t = t + monto_delivery;
                }

                t=parseFloat(t.toFixed(2));

                return t;
            },
            totalitems: function () {
                var t=0;
                var cntCombos = 0;
                $.each(this.detalles,function (i,det) {
                    t+=(det.cantidad*1);
                    if(det.item.combo){
                        cntCombos++;
                    }
                });

                this.cntCombos = cntCombos;

                return t;
            },
            vuelto: function () {
                var t=this.total, r=this.recibido, v=0, ai=this.abono_ini;

                v= this.credito ? r-ai : r-t;//Vuelto es igual a recibio menos total

                return v<1 ? 0 : v.toFixed(0);
            },
            habilitaProcesar: function () {

                //Si el cliente es el mismo negocio solo valida que haya algun articulo
                if(this.clienteVenta==2 || this.credito){
                    return this.totalitems>0;

                }
                //Cualquier otro cliente valida que el moto de la venta sea mayor a 0 y que lo recibido sea mayor o igual al moto total
                else{
                    return (this.total>0 && this.recibido>=this.total)
                }

            }
        },
    });

    $(function () {


        $("#recibido").keypress(function (e) {
            console.log(e);
            if (e.keyCode == 13) {
                e.preventDefault();
                $("#btn-procesar").focus();
            }
        });

        $('#clientes').select2({
            language: 'es',
            maximumSelectionLength: 1,
            allowClear: true
        }).on('change',function (e) {

            var cliente = parseInt(e.target.value);
            vm.clienteVenta = cliente;
        });

        $("#btn-procesar").click(function () {
            $(this).button('loading');
        });


    })
</script>
@endpush
