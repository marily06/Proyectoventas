@extends('ecommerce.layout.app')

@section('title_page','INICIO')

@section('content')




    <!-- PAGE-CONTENT START -->
    <section class="page-content" id="agregar_items_vue">

        <!-- SLIDER-AREA START -->
        <div class="slider-area margin-bottom-80">
            <div class="bend niceties preview-2">

                @php
                    $total = \App\Models\Item::portada()->count();
                    $limite = $total > 4 ? 4 : $total;
                    $items = \App\Models\Item::portada()->get()->random($limite)
                @endphp

                <div id="ensign-nivoslider" class="slides">
                    @foreach($items as $i => $item)
                        <img src="{{$item->img('1920x400')}}" alt="" title="#slider-direction-{{$i}}"  />
                    @endforeach
                </div>

                @foreach($items as $i => $item)
                    <div id="slider-direction-{{$i}}" class="{{$i==0 ? 't-cn' :''}} slider-direction">
                        <div class="slider-progress"></div>
                        <div class="slider-content t-lfl s-tb">
                            <div class="title-container s-tb-c title-compress">
                                <div class="slider-1">
                                    <div class="wow fadeInUpBig" data-wow-duration="1.2s" data-wow-delay="0.5s">
                                        <h1 class="title1">
                                            {{$item->nombre}}
                                        </h1>
                                    </div>
                                    <div class="image wow fadeInUpBig" data-wow-duration="1.5s" data-wow-delay="0.7s">
                                        <span><img src="ecommerce/img/slider/slider-1/slider-border.png" alt="" /></span>
                                    </div>
                                    <div class="wow fadeInUpBig" data-wow-duration="1.8s" data-wow-delay="0.9s">
                                        <p class="slider-brief">
                                            {{$item->descripcion}}
                                        </p>
                                    </div>
                                    <div class="wow fadeInUpBig" data-wow-duration="2s" data-wow-delay="1.1s">
                                        <a href="{{route('productos.ficha',$item->id)}}" class="shop-now">
                                            {{__('shop now')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <!-- SLIDER-AREA END -->


        <!-- NEW-COLLECTION START -->
        <div class="new-collection-area fix margin-bottom-80">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <h2 class="border-left-right-btm">
                            {{__('New Collection')}}
                        </h2>
                    </div>
                </div>
                @foreach(\App\Models\Item::with("categorias")->orderBy('created_at','desc')->take(3)->get() as $i => $item)
                <div class="col-xl-4 col-md-6 col-sm-6 padding-0">
                    <div class="single-collection">
                        <div class="collection-photo">
                            <a href="#"><img src="{{$item->img("600x470")}}" alt="" /></a>
                        </div>
                        <div class="collection-brief">
                            <div class="text-right">
                                <span class="new">new</span>
                            </div>
                            <h2>{{$item->nombre}} </h2>
                            @foreach($item->categorias as $cat)
                            <ul>
                                <li>{{$cat->nombre}}</li>
                            </ul>
                            @endforeach
                            <a href="{{route('productos.ficha',$item->id)}}" class="shop-now active-shop-now">
                                {{__('shop now')}}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- NEW-COLLECTION END -->

        <!-- PRODUCT-AREA START -->
        <div class="product-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <h2 class="border-left-right-btm">
                                {{__('Popular')}}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div id="active-product" class="product-slider">
                @foreach(\App\Models\Item::with("categorias")->orderBy('created_at','desc')->take(10)->get() as $i => $item)
                    <!-- Single-product start -->
                    <div class="single-product">
                        <div class="product-photo">
                            <a href="#">
                                <img class="primary-photo" src="{{$item->img('382x450')}}" alt="" />
                                <img class="secondary-photo" src="{{$item->img('382x450',1)}}" alt="" />
                            </a>
                            <div class="pro-action">
                                <a href="#" class="action-btn"><i class="sp-heart"></i>
                                    <span>
                                        {{__("Wishlist")}}
                                    </span>
                                </a>
                                <a href="#" @click.prevent="agregarCarro({{$item->id}})" class="action-btn">
                                    <i class="sp-shopping-cart"></i>
                                    <span>
                                        {{__("Add to cart")}}
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="product-brief">

                            @include('ecommerce.partials.estrellas_calificacion',['calificacion' => $item->calificacion_total])

                            <h2>
                                <a href="{{route('productos.ficha',$item->id)}}">{{$item->nombre}}</a>
                            </h2>
                            <h3>{{dvs().nfp($item->precio_venta)}}</h3>
                        </div>
                    </div>
                    <!-- Single-product end -->
                @endforeach
            </div>
        </div>
        <!-- PRODUCT-AREA END -->


        <!-- BEST-SELL-AREA START -->
        <div class="best-sell-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title text-center">
                            <h2 class="border-left-right-btm">
                                {{__('Best Sell')}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        $categorias = \App\Models\ItemCategoria::with('items')->orderBy('created_at','desc')->take(3)->get()
                    @endphp
                    <div class="col-lg-12">
                        <!-- best-sell-menu -->
                        <ul role="tablist" class="nav d-block best-sell-menu">
                            @foreach($categorias as $i => $cat)
                                <li role="presentation">
                                    <a href="#cat_{{$cat->id}}" class="{{$i == 0 ? 'active' : '' }}"  role="tab" data-bs-toggle="tab">
                                        {{$cat->nombre}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <!-- best-sell-product -->
                        <div class="tab-content best-sell-product">

                            @foreach($categorias as $i => $cat)
                                @php
                                    $total = $cat->items->count();
                                    $limite = $total > 9 ? 9 : $total;

                                @endphp
                            <div role="tabpanel" class="tab-pane fade {{$i==0 ? 'show active' : ''}}" id="cat_{{$cat->id}}">
                                <div class="row">
                                    @foreach($cat->items->random($limite) as $item)
                                        <div class="col-md-4">
                                            <!-- Single-product start -->
                                            <div class="single-product">
                                                <div class="product-photo">
                                                    <a href="#">
                                                        <img class="primary-photo" src="{{$item->img('370x400',1)}}" alt="" />
                                                        <img class="secondary-photo" src="{{$item->img('370x400')}}" alt="" />
                                                    </a>
                                                    <div class="pro-action">
                                                        <a href="#" class="action-btn"><i class="sp-heart"></i>
                                                            <span>
                                                                {{__("Wishlist")}}
                                                            </span>
                                                        </a>
                                                        <a href="#" @click.prevent="agregarCarro({{$item->id}})" class="action-btn">
                                                            <i class="sp-shopping-cart"></i>
                                                            <span>
                                                                {{__("Add to cart")}}
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-brief">
                                                    <h2>
                                                        <a href="{{route('productos.ficha',$item->id)}}">
                                                            {{$item->nombre}}
                                                        </a>
                                                    </h2>
                                                    <div class="product-brief-inner">
                                                        <h3>{{dvs().nfp($item->precio_venta)}}</h3>

                                                        @include('ecommerce.partials.estrellas_calificacion',['calificacion' => $item->calificacion_total])

                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Single-product end -->
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEST-SELL-AREA END -->

        <!-- ALL-PRODUCT-VIEW START -->
        <div class="all-product-view-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="all-product-view-link">
                            <a href="{{route('tienda')}}" class="shop-now">
                                {{__("View All")}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ALL-PRODUCT-VIEW END -->



    </section>
    <!-- PAGE-CONTENT END -->

@endsection


@include('ecommerce.partials.script_agregar_carrito')
