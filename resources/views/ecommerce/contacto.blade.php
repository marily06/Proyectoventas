@extends('ecommerce.layout.app')

@section('title_page',__('Contact'))

@section('content')

    <!-- PAGE-CONTENT START -->
    <section class="page-content">
        <!-- PAGE-BANNER START -->

        @include('ecommerce.partials.titulo',['titulo' => __('Contact')])
        <!-- PAGE-BANNER END -->
        <!-- CONTACT-AREA START -->
        <div class="contact-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 px-sm-5">

                        <div class="row">

                            <div class="col-lg-8">
                                <h3>
                                    <i class="fa fa-envelope-o"></i>
                                    {{__('Leave a Message')}}
                                </h3>
                                <form id="" action="">
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="nombre">
                                                {{__('Name')}}
                                            </label>
                                            <input class="form-control" name="nombre" type="text" placeholder="{{__('Name')}}" />
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="correo">
                                                {{__('Email')}}
                                            </label>
                                            <input class="form-control" name="correo" type="email" placeholder="{{__('Email')}}" />
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="asunto">
                                                {{__('Subject')}}
                                            </label>
                                            <input class="form-control" name="asunto" type="text" placeholder="{{__('Subject')}}" />
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="correo">
                                                {{__('Message')}}
                                            </label>
                                            <textarea class="form-control" name="mensaje" id="message" cols="30" rows="5" placeholder="{{__('Message')}}"></textarea>

                                        </div>
                                        <div class="form-group col-lg-12 d-grid gap-2">
                                            <br>
                                            <button type="submit" class="btn btn-block btn-success ">
                                                {{__('Submit Form')}}
                                            </button>

                                        </div>
                                    </div>

                                </form>
                            </div>


                            <div class="col-lg-4 ">
                                <h3 class="mt-2">
                                    {{__('Contact info')}}
                                </h3>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <i class="fa fa-map-marker"></i> <strong>
                                            {{__('Address')}}:
                                        </strong>
                                        {{getDireccionNegocio()}}
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-envelope"></i> <strong>
                                            {{__('Phone Number')}}:
                                        </strong>
                                        {{getPbx()}}
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-mobile"></i> <strong>
                                            {{__('Email')}}:
                                        </strong>
                                        <a href="mailto:{{getCorreoNegocio()}}">
                                            {{getCorreoNegocio()}}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CONTACT-AREA END -->
    </section>
    <!-- PAGE-CONTENT END -->

@endsection
