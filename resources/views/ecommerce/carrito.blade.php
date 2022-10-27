@extends('ecommerce.layout.app')

@section('title_page',__("Shopping Cart"))

@push('css')
    <style>

    </style>

@endpush

@section('content')

    <section class="page-content">

        @include('ecommerce.partials.titulo',['titulo' => __("Shopping Cart")])

        <!-- SHOPPING-CART-AREA START -->
        <div class="shopping-cart-area margin-bottom-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="#">
                            <div class="table-content table-responsive">
                                <table>
                                    <thead>
                                    <tr>
                                        <th class="product-thumbnail">{{__("Image")}}</th>
                                        <th class="product-name">{{__("Name")}}</th>
                                        <th class="product-price">{{__("price")}}</th>
                                        <th class="product-quantity">{{__("Quantity")}}</th>
                                        <th class="product-subtotal">{{__("Subtotal")}}</th>
                                        <th class="product-remove">{{__("Remove")}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('carrito') as $item)
                                            <tr>
                                                <td class="product-thumbnail"><a href="#">
                                                        <img src="{{$item->miniatura}}" alt="" /></a>
                                                </td>
                                                <td class="product-name">
                                                    <a href="#">{{$item->nombre}}</a>
                                                </td>
                                                <td class="product-price">
                                                    <span class="amount">
                                                        {{dvs().nfp($item->precio_venta)}}
                                                    </span>
                                                </td>
                                                <td class="product-quantity">
                                                    <input type="text" value="{{$item->cantidad}}" /></td>
                                                <td class="product-subtotal">
                                                    {{dvs().nfp($item->sub_total)}}
                                                </td>
                                                <td class="product-remove">
                                                    <a href="#"><i class="pe-7s-close"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
{{--                            <div class="row">--}}
{{--                                <div class="col-lg-12">--}}
{{--                                    <div class="coupon">--}}
{{--                                        <input type="submit" value="update cart" />--}}
{{--                                        <span>do you have coupon code</span>--}}
{{--                                        <input type="text" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="row">
                                <div class="col-lg-5 offset-lg-7">
                                    <div class="cart-totals">
                                        <h2>Total</h2>
                                        <div class="table-cart table-responsive">
                                            <table>
                                                <tbody class="cart-totals-list">
                                                <tr>
                                                    <th>{{__("Subtotal")}}</th>
                                                    <td>
                                                        {{dvs().session('carrito')->sum('sub_total')}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{__("Discount")}}</th>
                                                    <td>
                                                        <span>
                                                        {{dvs()}} 0
                                                        </span>
                                                    </td>
                                                </tr>
{{--                                                <tr>--}}
{{--                                                    <th>{{__("Shipping")}}</th>--}}
{{--                                                    <td><p>free shipping</p></td>--}}
{{--                                                </tr>--}}
                                                <tr class="cart-total">
                                                    <th>{{__("Total")}}</th>
                                                    <td>
                                                        {{dvs().session('carrito')->sum('sub_total')}}
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div class="we-proceed-to-checkout">
                                                <a href="{{route('carrito.pagar')}}">
                                                    {{__("proceed to chackout")}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- SHOPPING-CART-AREA END -->

    </section>

@endsection


@push('scripts')
<script>

    const app = new Vue({
        el: '#root',
    });
</script>
@endpush
