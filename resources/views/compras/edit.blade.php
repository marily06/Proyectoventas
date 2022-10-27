@extends('layouts.app')

@section('title_page')
	Editar Compra
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">
                        Editar Compra
                    </h1>
                </div><!-- /.col -->
                <div class="col">
                    <a class="btn btn-outline-info float-right"
                       href="{{route('compras.index')}}">
                        <i class="fa fa-list" aria-hidden="true"></i>&nbsp;<span class="d-none d-sm-inline">Listado</span>
                    </a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            @include('adminlte-templates::common.errors')

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                           {!! Form::model($compra, ['route' => ['compras.update', $compra->id], 'method' => 'patch']) !!}
                                <div class="form-row">

                                    @include('compras.fields')
                                    <!-- Submit Field -->
                                    <div class="form-group col-sm-12">
                                        <button type="submit" onClick="this.form.submit(); this.disabled=true;" class="btn btn-outline-success">Guardar</button>
                                        <a href="{!! route('compras.index') !!}" class="btn btn-outline-secondary">Cancelar</a>
                                    </div>
                                </div>

                           {!! Form::close() !!}

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
