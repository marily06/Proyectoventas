@extends('ecommerce.layout.app')

@section('title_page',__('Brands'))


@section('content')


    <!-- PAGE-CONTENT START -->
    <section class="page-content">

    @include('ecommerce.partials.titulo',['titulo' => __('Brands')])

    <!-- CONTACT-AREA START -->
        <div class="contact-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 px-5">
                        <div class="row">
                        @foreach(\App\Models\Marca::with('media')->get() as $marca)

                            <!--Grid column-->
                                <div class="col-sm-3 mb-4">

                                    <div class="card " >
                                        <img src="{{$marca->img}}" class="card-img-top" alt="{{$marca->nombre}}">
                                        <div class="card-body d-grid gap-2">
                                            <a href="{{route('tienda')."?marca=".$marca->id}}" class="btn btn-outline-primary">
                                                {{$marca->nombre}}
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



