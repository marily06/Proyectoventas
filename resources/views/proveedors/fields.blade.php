<!-- Nit Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nit', 'Nit:') !!}
    {!! Form::text('nit', null, ['class' => 'form-control','maxlength' => 10,'maxlength' => 10,'maxlength' => 10]) !!}
</div>

<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control','maxlength' => 45,'maxlength' => 45,'maxlength' => 45]) !!}
</div>

<!-- Razon Social Field -->
<div class="form-group col-sm-6">
    {!! Form::label('razon_social', 'Razon Social:') !!}
    {!! Form::text('razon_social', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Correo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('correo', 'Correo:') !!}
    {!! Form::text('correo', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Telefono Movil Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono_movil', 'Telefono Movil:') !!}
    {!! Form::text('telefono_movil', null, ['class' => 'form-control','maxlength' => 8,'maxlength' => 8,'maxlength' => 8]) !!}
</div>

<!-- Telefono Oficina Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono_oficina', 'Telefono Oficina:') !!}
    {!! Form::text('telefono_oficina', null, ['class' => 'form-control','maxlength' => 8,'maxlength' => 8,'maxlength' => 8]) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::textarea('direccion', null, ['class' => 'form-control']) !!}
</div>

<!-- Observaciones Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('observaciones', 'Observaciones:') !!}
    {!! Form::textarea('observaciones', null, ['class' => 'form-control']) !!}
</div>