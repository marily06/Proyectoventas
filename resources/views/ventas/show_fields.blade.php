<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {!! Form::label('cliente', 'Cliente:') !!}
        {!! $venta->cliente->nombres." ".$venta->cliente->apellidos  !!}
        <br>

        {!! Form::label('fecha', 'Fecha:') !!}
        {!! $venta->fecha !!}
        <br>

        {!! Form::label('serie', 'N/S:') !!}
        {!! $venta->serie !!}-{!! $venta->numero !!}
        <br>

        {{--@if($venta->repartidor())--}}
            {{--{!! Form::label('repartidor', 'Repartidor:') !!}--}}
            {{--{!! $venta->repartidor()->name !!}--}}
            {{--<br>--}}
        {{--@endif--}}

    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {!! Form::label('vestado', 'Estado:') !!}
        {!! $venta->estado->descripcion !!}
        <br>

        {!! Form::label('user', 'Usuario:') !!}
        {!! $venta->user->name ?? 'sin user'!!}
        <br>

        {!! Form::label('created_at', 'Creado el:') !!}
        {!! $venta->created_at !!}
        <br>

        {{--{!! Form::label('updated_at', 'Actualizado el:') !!}--}}
        {{--{!! $venta->updated_at !!}--}}
        {{--<br>--}}
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        {!! Form::label('observaciones', 'Observaciones:') !!}
        {!! $venta->observaciones !!}
        <br>

    </div>
</div>
<br>
