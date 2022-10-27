<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control','maxlength' => 100,'maxlength' => 100,'maxlength' => 100]) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::textarea('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Web Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('web', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('web', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('web', 'Web', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Local Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('local', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('local', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('local', 'Local', ['class' => 'form-check-label']) !!}
    </div>
</div>


<!-- Ruta Procesa Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ruta_procesa', 'Ruta Procesa:') !!}
    {!! Form::text('ruta_procesa', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>

<!-- Credenciales Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('credenciales', 'Credenciales:') !!}
    {!! Form::textarea('credenciales', null, ['class' => 'form-control']) !!}
</div>

<!-- Icono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('icono', 'Icono:') !!}
    {!! Form::text('icono', null, ['class' => 'form-control','maxlength' => 255,'maxlength' => 255,'maxlength' => 255]) !!}
</div>