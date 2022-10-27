@extends('layouts.app')

@section('title_page')
	LISTADO DE VENTAS
@endsection

@include('layouts.plugins.select2')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">LISTADO DE VENTAS</h1>
                </div><!-- /.col -->
                <div class="col">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item">
                            <a class="btn btn-outline-success"
                                href="{!! route('ventas.create') !!}">
                                <i class="fa fa-plus"></i>
                                <span class="d-none d-sm-inline">Nueva Venta</span>
                            </a>
                        </li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">


            <div class="row">
                <div class="col">
                    <div class="card card-outline card-success">
                        <div class="card-header p-1">
                            <h3 class="card-title">Filtros</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-2">
                            {!! Form::open(['rout' => 'ventas.index.post','id' =>'form-filter-ventas']) !!}
                            <div class="form-row">
                                <div class="form-group col-sm-4">
                                    {!! Form::label('cliente_id','Cliente: ') !!}
                                    {!!
                                        Form::select(
                                            'cliente_id',
                                            select(\App\Models\Cliente::class,'full_name','id',null)
                                            , $cliente_id ?? null
                                            , ['id'=>'clientes','class' => 'form-control select2-simple','multiple','style'=>'width: 100%']
                                        )
                                    !!}
                                </div>

                                <div class="form-group col-sm-2">
                                    {!! Form::label('del', 'Del:') !!}
                                    {!! Form::date('del', iniMesDb(), ['class' => 'form-control ']) !!}
                                </div>
                                <div class="form-group col-sm-2">
                                    {!! Form::label('al', 'Al:') !!}
                                    {!! Form::date('al', hoyDb(), ['class' => 'form-control ']) !!}
                                </div>
                                <div class="form-group col-sm-4">
                                    {!! Form::label('item_id','Artículo: ') !!}
                                    {!!
                                        Form::select(
                                            'item_id',
                                            select(\App\Models\Item::class,'nombre','id',null)
                                            , $item_id ?? null
                                            , ['id'=>'items','class' => 'form-control select2-simple','multiple','style'=>'width: 100%']
                                        )
                                    !!}
                                </div>


                                <div class="form-group col-sm-3">
                                    {!! Form::label('usuarios','Usuario: ') !!}
                                    {!!
                                        Form::select(
                                            'usuario',
                                            select(\App\Models\User::whereHas('ventas'),'name','id',null)
                                            , null
                                            , ['id'=>'usuarios','class' => 'form-control select2-simple','multiple','style'=>'width: 100%']
                                        )
                                    !!}
                                </div>

                                <div class="form-group col-sm-3">
                                    {!! Form::label('estado_id','Estado: ') !!}
                                    {!!
                                        Form::select(
                                            'estado',
                                            select(\App\Models\VentaEstado::class,'nombre','id',null)
                                            , $estado ?? null
                                            , ['id'=>'estados','class' => 'form-control select2-simple','multiple','style'=>'width: 100%']
                                        )
                                    !!}
                                </div>



                                <div class="form-group col-sm-2">
                                    {!! Form::label('codigo', 'Codigo:') !!}
                                    {!! Form::text('codigo', null, ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-2">
                                    {!! Form::label('boton','&nbsp;') !!}
                                    <div>
                                        <button type="submit" id="boton" class="btn btn-info">
                                            <i class="fa fa-sync"></i> Filtrar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           @include('ventas.table')
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@push('scripts')
<script>


    $(function () {
        $('#form-filter-ventas').submit(function(e){

            e.preventDefault();
            table = window.LaravelDataTables["dataTableBuilder"];

            table.draw();
        });
    })
</script>
@endpush
