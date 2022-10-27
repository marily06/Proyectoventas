@extends('layouts.app')

@section('title_page','Pedidos')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">Pedidos </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" id="root">
        <div class="container-fluid">




            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @forelse($pedidos as $pedido)
                        <div class="col-sm-6 col-md-6 col-lg-6" >
                            <div class="card card-outline" >
                                <div class="card-header">
                                    <h3 class="card-title">
                                        # <span > {{$pedido->id}}</span>
                                    </h3>

                                    <div class="card-tools">
                                        <span v-tooltip="'Pedido web'">
                                            <i class="fab fa-internet-explorer text-info fa-2x"></i>
                                            &nbsp
                                        </span>

                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-1 ">
                                    <ul>
                                        @foreach($pedido->detalles as $detalle)
                                        <li >
                                            <span >{{nf($detalle->cantidad)}}</span>&nbsp;
                                            <span >{{$detalle->item->nombre}}</span>&nbsp;
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- /.card-body -->
                                <div class="card-footer p-0">
                                    <!-- Datos Cliente -->
                                    <div class="row" >
                                        <div class="col text-sm">
                                            <span class="text'muted">Cliente:</span>
                                            <span class="font-weight-bold" >
                                                {{$pedido->nombre_entrega}}
                                            </span>
                                            <br>

                                            <span class="text'muted">Teléfono:</span>
                                            <span class="font-weight-bold" >
                                                {{$pedido->telefono}}
                                            </span>
                                            <br>

                                            <span class="text'muted">Dirección:</span>
                                            <span class="font-weight-bold" >
                                                {{$pedido->direccion}}
                                            </span>
                                            <br>

                                            <span class="text'muted">Correo:</span>
                                            <span class="font-weight-bold" >
                                                {{$pedido->correo}}
                                            </span>
                                            <br>

                                            <span class="text'muted">Observaciones:</span>
                                            <span class="font-weight-bold" >
                                                {{$pedido->observaciones}}
                                            </span>
                                            <br>

                                        </div>
                                    </div>



                                    <!-- Estado y botones -->
                                    <div class="row">
                                        <div class="col">

                                            <!-- Label Estado -->
                                            <span class="text-left badge badge-info text-lg mt-1 ml-1">
                                                {{$pedido->estado->nombre}}
                                            </span>


                                            <!--            Grupo de botones
                                            ------------------------------------------------------------------------>
                                            <span class="float-right" >

                                                @if($pedido->puedePreparar())
                                                <a href="{{route('pedidos.cambio.estado',$pedido->id)}}" class="btn btn-outline-success" v-tooltip.top-center="'Preparar'" >
                                                    <i class="fa fa-shopping-bag" > </i>
                                                </a>
                                                @endif


                                                @if($pedido->puedeLista())
                                                <a href="{{route('pedidos.cambio.estado',$pedido->id)}}" class="btn btn-outline-info" v-tooltip.top-center="'Lista'">
                                                    <i class="fa fa-check" > </i>
                                                </a>
                                                @endif

                                                @if($pedido->puedeDespachar())
                                                <a href="{{route('pedidos.cambio.estado',$pedido->id)}}" class="btn btn-outline-info" v-tooltip.top-center="'Despachar'">
                                                    <i class="fa fa-check" > </i>
                                                </a>
                                                @endif


                                                @if($pedido->puedeAnular())
                                                <a href="{{route('pedidos.anular',$pedido->id)}}" class="btn btn-outline-danger" v-tooltip.top-center="'Anular'" >
                                                    <i class="fa fa-undo" > </i>
                                                </a>
                                                @endif
                                            </span>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="col text-center text-primary">
                                <h2>
                                    No hay Pedidos pendientes!!!
                                </h2>
                            </div>
                        @endforelse
                    </div>
                </div>
{{--                <div class="overlay" v-show="loading">--}}
{{--                    <i class="fa fa-sync-alt fa-spin"></i>--}}
{{--                </div>--}}
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        var EventBus = new Vue;

        new Vue({
            el: '#root',
            mounted() {
                //console.log('Instancia vue montada');
            },
            created() {
                //console.log('Instancia vue creada');
            },
            data: {

            },
            methods: {

            }
        });
    </script>
@endpush
