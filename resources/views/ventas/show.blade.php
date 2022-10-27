@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Venta
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include('ventas.show_fields')

                    </div>

                    <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        @include('ventas.tabla_detalles')
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="{!! route('ventas.index') !!}" class="btn btn-default">Regresar</a>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <a href="{!! route('ventas.factura') !!}" class="btn btn-primaari">
                            <i class="fa fa-print"></i> Imprimir
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
