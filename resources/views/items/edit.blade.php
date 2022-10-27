@extends('layouts.app')


@include('layouts.plugins.select2')
@include('layouts.plugins.bootstrap_fileinput')

@section('title_page')
	Editar {{$item->nombre}}
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">
                        Editar Artículo
                    </h1>
                </div><!-- /.col -->
                <div class="col">
                    <a class="btn btn-outline-info float-right"
                       href="{{route('items.index')}}">
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

                            {!! Form::model($item, ['route' => ['items.update', $item->id], 'method' => 'patch',"enctype"=>"multipart/form-data","autocomplete"=>"off"]) !!}
                                <div class="form-row">

                                    @include('items.fields')
                                    <!-- Submit Field -->
                                    <div class="form-group col-sm-12">
                                        <button type="submit" onClick="this.form.submit(); this.disabled=true;" class="btn btn-outline-success">Guardar</button>
                                        <a href="{!! route('items.index') !!}" class="btn btn-outline-secondary">Cancelar</a>
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

    @include('items.modal_form_marcas')
    @include('unimeds.modal_create')
    @include('item_categorias.modal_form_create')
@endsection
