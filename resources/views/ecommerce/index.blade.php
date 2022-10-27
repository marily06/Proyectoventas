@extends('ecommerce.layout.app')

@section('htmlheader_title','Inicio')

@push('css')
    <style>
        .carousel-item {
            height: 65vh;
            min-height: 300px;
            background: no-repeat center center scroll;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        header {
            margin-top: 57px;
        }
        .btn-float{
            border-radius:50px;
            text-align:center;
        }
    </style>
    @endpush

@section('header')


@endsection

@section('content')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">

            @forelse($items as $i => $item)
                <!-- Slide One - Set the background image for this slide in the line below -->
                    <div class="carousel-item {{$i == 0 ? 'active' : ''}}" style="background-image: url('{{$item->img}}')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>{{$item->nombre}}</h3>
                            <p>{!! $item->descripcion !!}</p>
                        </div>
                    </div>
                @empty
                    <div class="carousel-item active" style="background-image: url('{{asset('img/default.svg')}}')">
                        <div class="carousel-caption d-none d-md-block">
                            <h3>No hay Artículos</h3>
                            <p></p>
                        </div>
                    </div>
                @endforelse
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>
    <div class="content">
        <!-- Page Content -->
        <div class="container pt-3">

            <h1 >Bienvenido a {{config('app.name')}}</h1>


            <!-- Portfolio Section -->
            <h2>{{__('Top Ten')}}</h2>

            <div class="row">
                @foreach($itemsTopTen as $item)
                    <div class="col-sm-3 mb-4">

                        <div class="card card-widget widget-user">
                            @if($item->esNuevo())
                                <div class="ribbon-wrapper">
                                    <div class="ribbon bg-success ">
                                        <b class="text-white">{{__('New')}}</b>
                                    </div>
                                </div>
                            @endif

                            @if($item->estaEnOferta())
                                <div class="ribbon-wrapper">
                                <div class="ribbon bg-warning ">
                                    <b class="text-white">Oferta</b>
                                </div>
                            </div>
                            @endif
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <a href="{{route('productos.ficha',$item->id)}}">

                                <div class="widget-user-header text-white"
                                     style="background: url('{{$item->thumb}}') no-repeat; background-size: 100% 100%">
                                    {{--                                                <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>--}}
                                    {{--                                                <h5 class="widget-user-desc text-right">Web Designer</h5>--}}
                                </div>
                            </a>

                            <div class="card-body text-center py-1">
                                <h5>
                                    <strong>
                                        <a href="{{route('productos.ficha',$item->id)}}" class="dark-grey-text">
                                            {{$item->nombre}}
                                        </a>
                                    </strong>
                                </h5>

                                <h4 class="font-weight-bold">
                                    <del class="text-muted text-sm">{{dvs(). nfp($item->precio_venta + ($item->precio_venta*0.15) )}}</del>
                                    <span class="pull-right text-success">{{dvs().$item->precio_venta}}</span>
                                </h4>



                            </div>
                            <div class="card-footer text-center py-1 px-1 " >

                                <a href="{{route('productos.ficha',$item->id)}}" type="button" class="btn btn-sm btn-secondary btn-float float-left elevation-3 ">
                                    detalle
                                </a>

                                <button type="button" class="btn btn-sm btn-info btn-float float-right elevation-3 " @click="add('{{$item->id}}')">


                                                        <span v-show="idAdding!='{{$item->id}}'">
                                                            <i class="fas fa-shopping-cart "></i>
                                                        </span>
                                    <span v-show="idAdding=='{{$item->id}}'" >
                                                            <i class="fa fa-spinner fa-spin "></i>
                                                        </span>
                                    Agregar
                                </button>

                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
            <!-- /.row -->


            <!-- Features Section -->
{{--            <div class="row">--}}
{{--                <div class="col-lg-6">--}}
{{--                    <h2>{{__(':Business Features',['Business' => config('app.nombre_negocio')])}}</h2>--}}
{{--                    <p>The Modern Business template by Start Bootstrap includes:</p>--}}
{{--                    <ul>--}}
{{--                        <li>--}}
{{--                            <strong>Bootstrap v4</strong>--}}
{{--                        </li>--}}
{{--                        <li>jQuery</li>--}}
{{--                        <li>Font Awesome</li>--}}
{{--                        <li>Working contact form with validation</li>--}}
{{--                        <li>Unstyled page elements for easy customization</li>--}}
{{--                    </ul>--}}
{{--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>--}}
{{--                </div>--}}
{{--                <div class="col-lg-6">--}}
{{--                    <img class="img-fluid rounded" src="https://placehold.it/700x450" alt="">--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- /.row -->

            <hr>

            <!-- Call to Action Section -->
            <div class="row mb-4">
{{--                <div class="col-md-8">--}}
{{--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.</p>--}}
{{--                </div>--}}
                <div class="col-md-4">
                    <a class="btn btn-lg btn-outline-info btn-block" href="{{route('web.productos')}}">{{__('Show all items')}}</a>
                </div>
            </div>

            <br>
            <br>
            <br>

        </div>
        <!-- /.container -->
    </div>

@endsection


@push('scripts')
    <script src="{{ url (mix('js/ecommerce/productos.js')) }}" type="text/javascript"></script>
@endpush
