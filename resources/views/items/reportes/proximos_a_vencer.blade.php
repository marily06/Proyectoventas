@extends('layouts.app')

@section('title_page','Reporte Artículos Próximos A Vencer')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">Reporte Artículos Próximos A Vencer</h1>
                </div><!-- /.col -->
                <div class="col">
                    <a class="btn btn-outline-info float-right" href="{!! route('home') !!}">
                        <i class="fa fa-list"></i>
                        <span class="d-none d-sm-inline">Listado</span>
                    </a>
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

                            {!! Form::open(['rout' => 'rpt.items.vencen','id' =>'form-filter-items-vencen']) !!}
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    {!! Form::label('cliente_id','Meses a validar: ') !!}
                                    {!!
                                        Form::select(
                                            'meses'
                                            ,[1 => '1 mes',2 =>'2 meses',3 =>'3 meses',4 =>'4 meses',5 =>'5 meses',6 =>'6 meses']
                                            , 1
                                            , ['id'=>'meses','class' => 'form-control',]
                                        )
                                    !!}
                                </div>

                                <div class="form-group col-sm-4">
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

                            <div class="table-responsive">
                                {!! $dataTable->table(['width' => '100%']) !!}
                            </div>

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


@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
        $(function () {
            var dt = window.LaravelDataTables["dataTableBuilder"];

            //Cuando dibuja la tabla
            dt.on( 'draw.dt', function () {
                $(this).addClass('table-sm  table-bordered table-hover');
            });


            $('#form-filter-items-vencen').submit(function(e){

                e.preventDefault();
                table = window.LaravelDataTables["dataTableBuilder"];

                table.draw();
            });

        })
    </script>
@endsection
