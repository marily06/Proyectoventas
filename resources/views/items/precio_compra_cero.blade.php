@extends('layouts.app')
@include('layouts.plugins.datatables')

@section('content')
    <section class="content-header">
        <h1>
            Agregar costo compra Artículo
        </h1>
    </section>
    <div class="content">

        @include('layouts.errores')
        <div class="box box-success">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'items.store.precio.compra']) !!}

                    <div class="form-group col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-condensed table-striped" id="tbl-dets">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nombre</th>
                                    <th>Categoria</th>
                                    <th>Precio Venta</th>
                                    <th width="10%">Precio costo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{$item->codigo}}</td>
                                        <td>{{$item->nombre}}</td>
                                        <td>{{$item->icategoria->nombre}}</td>
                                        <td>{{$item->precio_venta}}</td>
                                        <td>
                                            {!! Form::text('precios[]', 0, ['class' => 'form-control input-sm precio-compra']) !!}
                                            {!! Form::hidden('items[]', $item->id, ['class' => 'form-control input-sm']) !!}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Submit Field -->
                    <div class="form-group col-sm-12">
                        {!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
                        <a href="{!! route('items.index') !!}" class="btn btn-default">Cancelar</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<!--    Scripts
------------------------------------------------->
<script>
    $(function () {

        $('#tbl-dets').DataTable( {
//            dom: 'Brtip',
            paginate: false,
            //ordering: false,
            buttons: [],
            scrollY: '200px',
            "order": []
        } );


        $('div.dataTables_filter input').focus()

        $('.precio-compra').focus(function () {
            $(this).select();
        })

    })
</script>
@endpush
