@include('layouts.plugins.bootstrap_datetimepicker')

@php
    $readOnly = '';

    if(isset($cliente)){
        if ($cliente->id==\App\Models\Cliente::CF){
            $readOnly='readonly';
        }
    }
@endphp


<!-- Nit Field -->
<div class="form-group col-sm-3">
    {!! Form::label('nit', 'Nit:') !!}
    {!! Form::text('nit', null, ['class' => 'form-control',$readOnly]) !!}
</div>

<!-- DPI Field -->
<div class="form-group col-sm-3">
    {!! Form::label('dpi', config('app.identificacion_persona','DPI').' :') !!}
    {!! Form::text('dpi', null, ['class' => 'form-control',$readOnly]) !!}
</div>

<!-- Nombres Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombres', 'Nombres:') !!}
    {!! Form::text('nombres', null, ['class' => 'form-control',$readOnly]) !!}
</div>

<!-- Apellidos Field -->
<div class="form-group col-sm-6">
    {!! Form::label('apellidos', 'Apellidos:') !!}
    {!! Form::text('apellidos', null, ['class' => 'form-control',$readOnly]) !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-3">
    {!! Form::label('telefono', 'Telefono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-3">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<!-- Genero Field -->
<div class="form-group col-sm-3">
    {!! Form::label('genero', 'Genero:') !!}
    <div class="btn-group" data-toggle="buttons" style="width: 100%">
        @if(isset($cliente))
            <label class="btn btn-default {{$cliente->genero=='M' ? 'active' : ''}}">
                <input type="radio" name="genero" id="option2" value="M" autocomplete="off" {{$cliente->genero=='M' ? 'checked' : ''}}> M
            </label>
            <label class="btn btn-default {{$cliente->genero=='F' ? 'active' : ''}}">
                <input type="radio" name="genero" id="option3" value="F" autocomplete="off" {{$cliente->genero=='F' ? 'checked' : ''}}> F
            </label>
        @else
            <label class="btn btn-default active">
                <input type="radio" name="genero" id="option2" value="M" autocomplete="off" checked> M
            </label>
            <label class="btn btn-default">
                <input type="radio" name="genero" id="option3" value="F" autocomplete="off" > F
            </label>
        @endif
    </div>
</div>


<!-- Fecha Nacimiento Field -->
<div class="form-group col-sm-3">
    {!! Form::label('fecha_nacimiento', 'Fecha Nacimiento:') !!}
    {!! Form::text('fecha_nacimiento', null, ['class' => 'form-control','id'=>'fecha_nacimiento']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::textarea('direccion', null, ['class' => 'form-control','rows'=>'2']) !!}
</div>
@push('scripts')
<!--    Scripts fields clientes
------------------------------------------------->
<script>
    $(function () {

        var hoy=new Date();

//        var manana=new Date(hoy.getTime() + 24*60*60*1000);

        $("#fecha_nacimiento").datetimepicker({
            format: 'DD/MM/YYYY',
        });

    })
</script>
@endpush
