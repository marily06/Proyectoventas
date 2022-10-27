@extends('ecommerce.layout.app')

@section('title_page',__('My Account'))

@section('content')

    <!-- PAGE-CONTENT START -->
    <section class="page-content">
        <!-- PAGE-BANNER START -->

        @include('ecommerce.partials.titulo',['titulo' => __('My Account')])
        <!-- PAGE-BANNER END -->

        <div class="my-account-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel-group  margin-btm-0" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-bs-toggle="collapse" href="#personal-info" aria-expanded="true">
                                            <i class="pe-7s-bookmarks"></i>
                                            <span>
                                                {{__("My Personal Information")}}
                                            </span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="personal-info" class="panel-collapse collapse show" data-bs-parent="#accordion" role="tabpanel">
                                    <div class="panel-body">
                                        <form action="#">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="billing-address">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="custom-form" placeholder="{{__("Full Name")}}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" class="custom-form" placeholder="{{__("Address")}}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <select class="custom-select custom-form">
                                                                    <option>City</option>
                                                                    <option>Dhaka</option>
                                                                    <option>New York</option>
                                                                    <option>London</option>
                                                                    <option>Melbourne</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <select class="custom-select custom-form">
                                                                    <option>Country</option>
                                                                    <option>Bangladesh</option>
                                                                    <option>United States</option>
                                                                    <option>United Kingdom</option>
                                                                    <option>Australia</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="text" class="custom-form" placeholder="{{__("Phone Number")}}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" name="email" class="custom-form" placeholder="{{__("Email")}}" />
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <textarea class="custom-form pt-2" placeholder="{{__("Additional information")}}"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="aceptar_terminos"/>
                                                                {{__("I have read and agree to the")}}
                                                                <a href="#">
                                                                    <b>
                                                                        {{__("Privacy Policy")}}
                                                                    </b>
                                                                </a>
                                                            </label>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="submit" class="custom-submit-2 save" value="Guardar" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a role="button" data-bs-toggle="collapse" href="#shipping-info" aria-expanded="false">
                                            <i class="pe-7s-cart"></i>
                                            <span>
                                                {{__("My shipping address")}}
                                            </span>
                                        </a>
                                    </h4>
                                </div>
                                <div id="shipping-info" class="panel-collapse collapse" data-bs-parent="#accordion" role="tabpanel">
                                    <div class="panel-body">
                                        <!-- CHECKOUT-AREA START -->
                                        <div class="checkout-area">
                                            <form action="#">
                                                <div class="row">
                                                    <!-- Shipping-Address Start -->
                                                    <div class="col-lg-12">
                                                        <div class="shipping-address">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <select class="custom-select custom-form">
                                                                        <option>Select Delivery Method</option>
                                                                        <option>Select Delivery Method</option>
                                                                        <option>Select Delivery Method</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input class="custom-form" type="text" placeholder="Subash" name="firstname"/>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input class="custom-form" type="text" placeholder="Chandra" name="lastname"/>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <input type="text" class="custom-form" placeholder="Address" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <select class="custom-select custom-form">
                                                                        <option>City</option>
                                                                        <option>Dhaka</option>
                                                                        <option>New York</option>
                                                                        <option>London</option>
                                                                        <option>Melbourne</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <select class="custom-select custom-form">
                                                                        <option>Country</option>
                                                                        <option>Bangladesh</option>
                                                                        <option>United States</option>
                                                                        <option>United Kingdom</option>
                                                                        <option>Australia</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input class="custom-form" type="text" placeholder="Phone Number" />
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <select class="custom-select custom-form">
                                                                        <option>Post Code</option>
                                                                        <option>012345</option>
                                                                        <option>0123456</option>
                                                                        <option>01234567</option>
                                                                        <option>012345678</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <input type="text" class="custom-form" placeholder="Email" name="email" />
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <textarea class="custom-form" placeholder="Order Note"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Shipping-Address End -->
                                                </div>
                                            </form>
                                        </div>
                                        <!-- CHECKOUT-AREA END -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel-group margin-btm-0" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#" >
                                            <i class="pe-7s-like"></i>
                                            <span>
                                                {{__("My Wishlist Information")}}
                                            </span>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a href="#">
                                            <i class="pe-7s-news-paper"></i>
                                            <span>
                                                {{__("Order history and details")}}
                                            </span>
                                        </a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- PAGE-CONTENT END -->

@endsection
