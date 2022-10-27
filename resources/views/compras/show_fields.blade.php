
<!-- Tipo Field -->
{!! Form::label('tipo', 'Tipo:') !!}
{!! $compra->tipo->nombre ?? '' !!}
<br>

<!-- Proveedore Id Field -->
{!! Form::label('proveedor', 'Proveedor :') !!}
{!! $compra->proveedor->nombre ?? '' !!}
<br>

<!-- Serie Field -->
{!! Form::label('serie', 'N/S:') !!}
{!! $compra->numero !!}-{!! $compra->serie !!}

<br>

<!-- Fecha ingreso Plan Field-->
{!! Form::label('fecha_ingreso_plan', 'Fecha entrega a bodega:') !!}
{!! $compra->fecha_ingreso_plan!!}

<br>

<!-- Fecha ingreso Field-->
{!! Form::label('fecha_ingreso', 'Fecha Recepción:') !!}
{!! $compra->fecha_ingreso!!}

<br>

<!-- Fecha del documento Field -->
{!! Form::label('fecha', 'Fecha del documento:') !!}
{!! $compra->fecha!!}

<br>

<!-- Fecha Credito Field-->
{!! Form::label('fecha_limite_credito', 'Fecha de pago:') !!}
{!! $compra->fecha_limite_credito!!}

<br>

<!-- Estado Id Field -->
{!! Form::label('estado', 'Estado:') !!}
{!! $compra->estado->nombre !!}
<br>

<!-- CompraEstado Id Field -->
{!! Form::label('observaciones', 'Observaciones:') !!}
{!! $compra->observaciones !!}
<br>

{{--<!-- Created At Field -->--}}
{{--{!! Form::label('created_at', 'Creado el:') !!}--}}
{{--{!! $compra->created_at !!}--}}
{{--<br>--}}
{{--<!-- Updated At Field -->--}}
{{--{!! Form::label('updated_at', 'Actualizado el:') !!}--}}
{{--{!! $compra->updated_at !!}--}}
{{--<br>--}}
{{--<br>--}}

