@extends('ecommerce.layout.app')

@section('title_page',$item->nombre)


@section('content')


    <section class="page-content" id="agregar_items_vue">
        <!-- PAGE-BANNER START -->
        <div class="page-banner-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE-BANNER END -->
        <!-- SINGLE-PRODUCT-AREA START -->
        <div class="single-product-aea margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="single-product-tab-content">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                @foreach($item->media as $i => $img)
                                    <div role="tabpanel" class="tab-pane {{$i==0 ? 'active' : ''}}" id="img-{{$i}}">
                                        <img src="{{$img->getUrl("382x450")}}" alt="" />
                                        <a href="{{$img->getUrl("600x470")}}"  data-lightbox="roadtrip" data-title="">
                                            <span class="view-full-screen" ><i class="sp-full-view"></i> view full screen</span>
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                            <!-- Nav tabs -->
                            <ul class="nav">
                                @foreach($item->media as $i => $img)
                                    <li class="{{$i==0 ? 'active' : ''}}">
                                        <a href="#img-{{$i}}"  data-bs-toggle="tab">
                                            <img src="{{$img->getUrl('382x450')}}" alt="" />
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h3 class="my-3">{{$item->nombre}}</h3>
                        <p>
                            @foreach($item->categorias as $cat)
                                <a href="{{route('tienda').'?categoria='.$cat->id}}" >
                                    <span class="badge bg-info mr-2">{{$cat->nombre}}</span>
                                </a>
                            @endforeach
                        </p>

                        <p>{!! $item->descripcion !!}</p>

                        <hr>


                        <div class="">
                            <h2 class="mb-0 text-success">
                                {{dvs().$item->precio_venta}}
                            </h2>
                            <h4 class="mt-0">
                                <small>
                                    Antes:
                                    <del>{{dvs(). nfp($item->precio_venta + ($item->precio_venta*0.15) )}}</del>
                                </small>
                            </h4>
                        </div>

                        <div class="row">
                            <div class="col-6">

                                <div class="input-group">
                                    <input type="number" value="1" v-model="cantidad" aria-label="Search" class="form-control">
                                    <div class="input-group-append">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-primary  btn-flat" @click.prevent="agregarCarro({{$item->id}})">

                                            <span v-show="!loading">
                                                <i class="fas fa-cart-plus fa-lg mr-2" ></i>
                                            </span>
                                            <span v-show="loading">
                                                <i class="fa fa-spinner fa-spin" ></i>
                                            </span>
                                            {{__('Add to cart')}}
                                        </button>
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">

                                <div class="input-group ">
                                    <div class="btn btn-secondary  btn-flat">
                                        <i class="fas fa-heart fa-lg mr-2"></i>
                                        Add to Wishlist
                                    </div>
                                </div>
                            </div>



                        </div>

                        <div class="mt-4">
                            <a href="#" class="text-gray me-2">
                                <i class="fab fa-facebook-square fa-2x"></i>
                            </a>
                            <a href="#" class="text-gray me-2">
                                <i class="fab fa-twitter-square fa-2x"></i>
                            </a>
                            <a href="#" class="text-gray me-2">
                                <i class="fas fa-envelope-square fa-2x"></i>
                            </a>
                            <a href="#" class="text-gray me-2">
                                <i class="fas fa-rss-square fa-2x"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- SINGLE-PRODUCT-AREA END -->

        <!-- SINGLE-PRODUCT-REVIEWS-AREA START -->
        <div class="single-product-reviews-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="discription-reviews-tab">
                            <!-- Nav tabs -->
                            <ul class="nav reviews-tab-menu" role="tablist">
                                <li role="presentation">
                                    <a class="active" href="#description" data-bs-toggle="tab">
                                        {{__('Description')}}
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a href="#reviews"  data-bs-toggle="tab">
                                    {{__('Reviews')}}
                                    </a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div role="tabpanel" class="tab-pane active" id="description">
                                    <div class="single-pro-product-description">
                                        {{$item->descripcion}}
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="reviews">
                                    <div class="product-page-comments">
                                        <h2>
                                            {{$item->comentarios->count()}}
                                            {{__('review')}}
                                        </h2>
                                        <ul>
                                            <!-- Single Comment -->
                                            @forelse($item->comentarios()->with('user.media')->orderBy('created_at','desc')->get() as $comentario)
                                                <li>
                                                    <div class="product-comments">
                                                        <img src="{{$comentario->user->img}}" alt="" />
                                                        <div class="product-comments-content">
                                                            <p><strong>{{$comentario->user->name}}</strong> -
                                                                <span>{{fechaHoraLtn($comentario->created_at)}}</span>
                                                                @include('ecommerce.partials.estrellas_calificacion',['calificacion' => $comentario->rating])
                                                            </p>
                                                            <div class="desc">
                                                                {{$comentario->descripcion}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li>
                                                    <div class="product-comments">
                                                        <div class="product-comments-content">
                                                            <div class="desc">
                                                                sin comentarios
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforelse

                                        </ul>
                                        <div class="review-form-wrapper">

                                            @guest
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="alert alert-secondary" role="alert">
                                                            <strong><a href="{{route('login')}}">Ingresa</a> para poder valorar y comentar </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endguest

                                            @auth

                                                <!--            Validación para que el mismo usuario no comente 2 veses
                                                                                ------------------------------------------------------------------------>
                                                @if(! $item->comentarios->contains('user_id', Auth::user()->id))
                                                    <!-- Comments Form -->

                                                @endif
                                                    <h3>
                                                        {{__('Add a review')}}
                                                    </h3>
                                                    <form action="{{route('productos.ficha',$item->id)}}" method="POST">
                                                        @csrf
                                                        <div class="your-rating">
                                                            <h5>
                                                                {{__('Your Rating')}}
                                                            </h5>

                                                            <span>
                                                    <ul id="list_rating" class="list-inline" style="font-size: 40px;">
                                                        <li class="list-inline-item star" data-number="1">
                                                            <span class="color-gold">
                                                                <i class="fa fa-star"></i>
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item star" data-number="2">
                                                            <span class="">
                                                                <i class="fa fa-star"></i>
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item star" data-number="3">
                                                            <span class="">
                                                                <i class="fa fa-star"></i>
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item star" data-number="4">
                                                            <span class="">
                                                                <i class="fa fa-star"></i>
                                                            </span>
                                                        </li>
                                                        <li class="list-inline-item star" data-number="5">
                                                            <span class="">
                                                                <i class="fa fa-star"></i>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </span>
                                                        </div>
                                                        <textarea id="product-message" cols="30" rows="10" placeholder="Your Rating"></textarea>
                                                        <input type="hidden" name="rating" id="rating" value="1">
                                                        <input type="submit" value="{{__('Submit')}}" />
                                                    </form>
                                            @endauth

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- SINGLE-PRODUCT-REVIEWS-AREA END -->

        <!-- SINGLE-PRODUCT-RELATED-AREA START -->
        <div class="single-product-related-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="related-product-title">
                            <h3>
                                {{__('Related Product')}}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="active-related-product shop-grid">
                @foreach($item->relacionados(6) as $rel)
                    @include('ecommerce.partials.tarjeta_producto',['item' => $rel])
                @endforeach


            </div>
        </div>
        <!-- SINGLE-PRODUCT-RELATED-AREA END -->

    </section>




@endsection

@include('ecommerce.partials.script_agregar_carrito')

@push('scripts')

    <script>

        $(function() {

            const ratingSelector = $('#list_rating');

            ratingSelector.find('li').on('click', function () {

                const number = $(this).data('number');

                console.log(number);

                $("#rating").val(number);

                ratingSelector.find('li span').removeClass('color-gold').each(function(index) {
                    if ((index + 1) <= number) {
                        $(this).addClass('color-gold');
                    }
                })
            })
        });
    </script>
@endpush




@push('css')
    <style>
        .map-responsive{
            overflow:hidden;
            padding-bottom:50%;
            position:relative;
            height:0;
        }
        .map-responsive iframe{
            left:0;
            top:0;
            height:100%;
            width:100%;
            position:absolute;
        }
        .color-gold {
            color: #ffd700
        }
    </style>
@endpush
