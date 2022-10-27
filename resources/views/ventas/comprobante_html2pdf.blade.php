<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <title>Factura</title>
    <link rel='stylesheet' href='{{asset('css/bootstrap.min.css')}}' media='all' />
    <link rel='stylesheet' href='{{asset('css/factura.css')}}' media='all' />
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.png')}}">
  </head>
  <body>

    <header class='clearfix'>
    <table width="100%">
      <tr>
        <td>
          <div id='logo'>
            <img src='{{getLogo()}}' style="max-width: 400px;  height: 100px">
          </div>
        </td>
        <td align="right">
          <div id='company'>
            <h2 class='name'>{{config('app.name')}}</h2>
            <div>{{config('app.direccion_negocio')}}</div>
            <div>Tel: {{config('app.telefono_negocio')}}</div>
            <div><a href='mailto:{{config('app.correo_negocio')}}'>{{config('app.mail_negocio')}}</a></div>
          </div>
        </td>
      </tr>
    </table>
  </header>
    <main style="height: auto">
      <div id='details'>
        <table width="100%">
          <tr>
            <td>
              <div id='client'>
                <div class='to'>Cliente:</div>
                <h2 class='name'>{{$venta->cliente->nombre_completo}}</h2>
                <div class='address'>NIT:</div>
                <div class='email'>{{$venta->cliente->nit}}</div>
              </div>
            </td>
            <td align="right">
              <div id='invoice'>
                  <h1>Comprobante de pago</h1>
                  <div class='date'>fecha: {{fecha($venta->fecha)}}</div>
                {{--<div class='date'>Due Date: 30/06/2014</div>--}}
              </div>
            </td>
          </tr>
        </table>
      </div>
      @include('ventas.tabla_detalles2',['venta' => $venta])
      <div class="text-muted">Atendió: {{$venta->usuarioCrea->name}}</div>
      <div id='thanks'>Gracias por su preferencia!</div>
      {{--<div id='notices'>--}}
        {{--<div>NOTICE:</div>--}}
        {{--<div class='notice'>A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>--}}
      {{--</div>--}}
    </main>


  </body>
</html>
