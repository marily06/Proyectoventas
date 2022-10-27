@extends('ecommerce.layout.app')

@section('title_page',__('Categories'))


@section('content')


    <!-- PAGE-CONTENT START -->
    <section class="page-content">

        @include('ecommerce.partials.titulo',['titulo' => __('Categories')])

        <!-- CONTACT-AREA START -->
        <div class="contact-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 px-5">
                        <div class="row">
                        @foreach(\App\Models\ItemCategoria::with('media')->conItemsWeb()->get() as $cat)

                            <!--Grid column-->
                                <div class="col-sm-3 mb-4">

                                    <div class="card " >
                                        <img src="{{$cat->img}}" class="card-img-top" alt="{{$cat->nombre}}">
                                        <div class="card-body d-grid gap-2">
                                            <a href="{{route('tienda')."?categoria=".$cat->id}}" class="btn btn-outline-primary">
                                                {{$cat->nombre}}
                                            </a>
                                        </div>
                                    </div>


                                </div>
                                <!--Grid column-->
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- CONTACT-AREA END -->
    </section>
    <!-- PAGE-CONTENT END -->


@endsection


