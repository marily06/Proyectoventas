@extends('ecommerce.layout.app')

@section('title_page',__('Pedido completado'))


@section('content')

    <!-- PAGE-CONTENT START -->
    <section class="page-content">
        <!-- PAGE-BANNER START -->

    @include('ecommerce.partials.titulo',['titulo' => __('Pedido completado')])
    <!-- PAGE-BANNER END -->
        <!-- CONTACT-AREA START -->
        <div class="contact-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 px-sm-5">

                        @include('ecommerce.partials.factura')
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTACT-AREA END -->
    </section>
    <!-- PAGE-CONTENT END -->

@endsection


