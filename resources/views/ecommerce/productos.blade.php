@extends('ecommerce.layout.app')

@section('title_page','Productos')

@section('content')

    <!-- PAGE-CONTENT START -->
    <section class="page-content" id="agregar_items_vue">
        <!-- PAGE-BANNER START -->
        <div class="page-banner-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-banner-menu">
                            <h2 class="page-banner-title">
                                @if(isset($categoria) || isset($marca))


                                    Productos
                                    @isset($categoria)
                                        <small>
                                            /Categoría: {{\App\Models\ItemCategoria::find($categoria)->nombre}}
                                        </small>
                                    @else
                                        <small>
                                            /Marca: {{\App\Models\Marca::find($marca)->nombre}}
                                        </small>
                                    @endisset
                                @else
                                    Productos
                                @endif
                            </h2>
                            <ul>
                                <li><a href="{{route('home')}}">home</a></li>
                                <li>Productos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE-BANNER END -->
        <!-- SHOP-AREA START -->
        <div class="shop-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <span class="shop-border"></span>
                    </div>
                    <div class="col-lg-3 order-lg-1 order-2">
                        <!-- widget-categories start -->
                        <aside class="widget widget-categories">
                            <h5>
                                {{__("Categories")}}
                            </h5>
                            <ul>
                                @foreach(\App\Models\ItemCategoria::whereHas('items')->get() as $cat)
                                <li class="{{$cat->id==request()->categoria ? 'active-li' :''}}">
                                    <a href="{{route('tienda')."?categoria=".$cat->id}}">
                                        {{$cat->nombre}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </aside>
                        <!-- widget-categories end -->
                        <!-- shop-filter start -->
                        <aside class="widget shop-filter">
                            <h3 class="sidebar-title">
                                {{__("price")}}
                            </h3>
                            <div class="info_widget">
                                <div id="slider-range"></div>
                                <div id ="amount">
                                    <input type ="text" name ="first_price" class="first_price" />
                                    <input type ="text" name ="last_price" class="last_price"/>
                                </div>
                                <button class="shop-now">
                                    {{__("filter")}}
                                </button>
                            </div>
                        </aside>
                        <!-- shop-filter end -->

                        <!-- widget-brand start -->
                        <aside class="widget widget-categories">
                            <h5 class="sidebar-title">
                                {{__("Brand")}}
                            </h5>
                            <ul class="">
                                @foreach(\App\Models\Marca::all() as $marca)
                                    <li class="{{$marca->id==request()->marca ? 'active-li' :''}}">
                                        <a href="{{route('tienda')."?marca=".$marca->id}}">
                                            {{$marca->nombre}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </aside>
                        <!-- widget-brand end -->
                        <!-- widget-top-brand start -->
                        <aside class="widget top-rated hidden-sm">
                            <h5 class="sidebar-title">
                                {{__("top rated")}}
                            </h5>
                            <div class="sidebar-product">

                                @foreach($itemsTop as $item)
                                    <!-- Single-product start -->
                                    <div class="single-product">
                                        <div class="product-photo">
                                            <a href="{{route('productos.ficha',$item->id)}}">
                                                <img class="primary-photo" src="{{$item->miniatura}}" alt=""/>
                                            </a>
                                        </div>
                                        <div class="product-brief">
                                            <h2>
                                                <a href="{{route('productos.ficha',$item->id)}}">
                                                    {{$item->nombre}}
                                                </a>
                                            </h2>
                                            <h3>
                                                {{dvs().nfp($item->precio_venta)}}
                                                <span>{{dvs().nfp($item->precio_venta + ($item->precio_venta*0.15))}}</span>
                                            </h3>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </aside>
                        <!-- widget-top-brand end -->
                    </div>
                    <div class="col-lg-9 order-1 order-lg-2">
                        <!-- Shop-Content start -->
                        <div class="shop-content">
                            <!-- product-toolbar start -->
                            <div class="product-toolbar">
                                <!-- Shop-menu -->
                                <ul class="nav shop-menu view-mode">
                                    <li>
                                        <a class="grid-view active" href="#grid-view" data-bs-toggle="tab"><i class="sp-grid-view"></i></a>
                                    </li>
                                    <li>
                                        <a class="list-view" href="#list-view" data-bs-toggle="tab"><i class="sp-list-view"></i></a>
                                    </li>
                                </ul>
{{--                                <div class="short-by d-none d-lg-block">--}}
{{--                                    <span>--}}
{{--                                        {{__('short by')}}--}}
{{--                                    </span>--}}
{{--                                    <select class="shop-select">--}}
{{--                                        <option value="1">default</option>--}}
{{--                                        <option value="1">default</option>--}}
{{--                                        <option value="1">default</option>--}}
{{--                                        <option value="1">default</option>--}}
{{--                                        <option value="1">default</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="short-by showing d-none d-lg-block">--}}
{{--                                    <span>--}}
{{--                                        {{__('showing')}}--}}
{{--                                    </span>--}}
{{--                                    <select class="shop-select">--}}
{{--                                        <option value="1">9</option>--}}
{{--                                        <option value="1">15</option>--}}
{{--                                        <option value="1">24</option>--}}
{{--                                        <option value="1">30</option>--}}
{{--                                        <option value="1">45</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
                                <!-- pagination -->
                                <div class="float-end">
{{--                                    <ul>--}}
{{--                                        <li class="active"><a href="#">1</a></li>--}}
{{--                                        <li><a href="#">2</a></li>--}}
{{--                                        <li><a href="#">3</a></li>--}}
{{--                                        <li><a href="#"><i class="sp-arrow-bold-right"></i></a></li>--}}
{{--                                    </ul>--}}
                                    @if(isset(request()->categoria)))

                                        {{$items->appends(['categoria' => $categoria])->links()}}

                                    @elseif(isset(request()->marca))

                                        {{$items->appends(['marca' => $marca])->links()}}

                                    @elseif(isset(request()->marca))

                                        {{$items->appends(['search' => $search])->links()}}

                                    @else

                                        {{$items->links()}}

                                    @endif
                                </div>
                            </div>
                            <!-- product-toolbar end -->

                            <!-- Shop-product start -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="grid-view">
                                    <div class="row shop-grid">

                                        @forelse($items as $item)

                                            <!-- Single-product start -->
                                            <div class="col-xl-4 col-md-6">
                                                @include('ecommerce.partials.tarjeta_producto',['item' => $item])
                                            </div>
                                            <!-- Single-product end -->

                                        @empty

                                            @if($search || $categoria  || $marca)

                                                <div class="card card-outline card-success">
                                                    <!-- /.card-header -->
                                                    <div class="card-body">

                                                        <h2 class="text-center text-warning text-uppercase py-5 my-5">
                                                            <i class="fa fa-exclamation-triangle fa-4x"></i>
                                                            <br>
                                                            <br>
                                                            <b>
                                                                @if($search)
                                                                    Lo sentimos no hay productos relacionados con tu búsqueda ({{$search}})
                                                                @elseif($categoria)
                                                                    Lo sentimos no hay productos en la categoría seleccionada ({{\App\Models\Icategoria::find($categoria)->nombre}})
                                                                @elseif($marca)
                                                                    Lo sentimos no hay productos en la marca seleccionada ({{\App\Models\Marca::find($marca)->nombre}})
                                                                @endif

                                                            </b>
                                                        </h2>
                                                        <br>
                                                        <br>
                                                        <br>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>

                                        @endif


                                    @endforelse


                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="list-view">
                                    <div class="row shop-list">
                                    @forelse($items as $item)

                                            <!-- Single-product start -->
                                            <div class="col-lg-12">
                                                @include('ecommerce.partials.tarjeta_producto_lista',['item' => $item])
                                            </div>
                                            <!-- Single-product end -->
                                        @empty

                                            @if($search || $categoria  || $marca)

                                                <div class="card card-outline card-success">
                                                    <!-- /.card-header -->
                                                    <div class="card-body">

                                                        <h2 class="text-center text-warning text-uppercase py-5 my-5">
                                                            <i class="fa fa-exclamation-triangle fa-4x"></i>
                                                            <br>
                                                            <br>
                                                            <b>
                                                                @if($search)
                                                                    Lo sentimos no hay productos relacionados con tu búsqueda ({{$search}})
                                                                @elseif($categoria)
                                                                    Lo sentimos no hay productos en la categoría seleccionada ({{\App\Models\Icategoria::find($categoria)->nombre}})
                                                                @elseif($marca)
                                                                    Lo sentimos no hay productos en la marca seleccionada ({{\App\Models\Marca::find($marca)->nombre}})
                                                                @endif

                                                            </b>
                                                        </h2>
                                                        <br>
                                                        <br>
                                                        <br>
                                                    </div>
                                                    <!-- /.card-body -->
                                                </div>

                                        @endif


                                    @endforelse
                                    </div>
                                </div>
                            </div>
                            <!-- Shop-product end -->
                            <!--Pagination-->
                            <nav class="d-flex justify-content-center wow fadeIn">
                                @if(isset(request()->categoria)))

                                {{$items->appends(['categoria' => $categoria])->links()}}

                                @elseif(isset(request()->marca))

                                    {{$items->appends(['marca' => $marca])->links()}}

                                @elseif(isset(request()->marca))

                                    {{$items->appends(['search' => $search])->links()}}

                                @else

                                    {{$items->links()}}

                                @endif
                            </nav>
                            <!--Pagination-->
                        </div>
                        <!-- Shop-Content end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- SHOP-AREA END -->



    </section>
    <!-- PAGE-CONTENT END -->

@endsection


@include('ecommerce.partials.script_agregar_carrito')

@push('css')
    <style>
        .active-li {
            background: #dedede none repeat scroll 0 0;
            color: #f6416c !important;
        }
    </style>
@endpush
