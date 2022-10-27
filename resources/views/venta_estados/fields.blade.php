<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control','maxlength' => 45,'maxlength' => 45,'maxlength' => 45]) !!}
</div>

<!-- Orden Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('orden', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('orden', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('orden', 'Orden', ['class' => 'form-check-label']) !!}
    </div>
</div>
