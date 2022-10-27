@extends('ecommerce.layout.app')

@section('title_page',__("Checkout"))

@section('content')


    <!-- PAGE-CONTENT START -->
    <section class="page-content" id="pagar">

        @include('ecommerce.partials.titulo',['titulo' => __("Checkout")])

        <!-- CHECKOUT-AREA START -->
        <div class="checkout-area margin-bottom-80">
            <div class="container">
                @include('layouts.partials.request_errors')

                <!-- Checkout-Billing-details and order start -->
                <div class="checkout-bill-order">
                    <form action="{{route('carrito.pagar.confirmar')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout-bill">
                                    <h3 class="title-7 margin-bottom-50">Billing Details</h3>
                                </div>
                                <div class="row coupon-info">
                                    <div class="col-lg-6">
                                        <p class="form-row-first">
                                            <label>Nombres  <span class="required">*</span></label>
                                            <input type="text"  name="nombres"  required/>
                                        </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="form-row-last">
                                            <label>Apellidos <span class="required">*</span></label>
                                            <input type="text" name="apellidos"  required/>
                                        </p>
                                    </div>
                                </div>
                                <div class="row coupon-info">
                                    <div class="col-lg-6">
                                        <p class="form-row-first">
                                            <label>Correo <span class="required">*</span></label>
                                            <input type="email" name="correo" required />
                                        </p>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="form-row-last">
                                            <label>Teléfono   <span class="required">*</span></label>
                                            <input type="text" name="telefono"  required/>
                                        </p>
                                    </div>
                                </div>
                                <div class="row coupon-info">
                                    <div class="col-lg-12">
                                        <p class="form-row-first">
                                            <label>Dirección de entrega </label>
                                            <textarea name="direccion" id="direccion" class="form-control" rows="3" required></textarea>
                                        </p>
                                    </div>
                                </div>
                                <div class="row coupon-info">
                                    <div class="col-lg-12">
                                        <p class="form-row-first">
                                            <label>Notas del pedido (opcional) </label>
                                            <textarea name="notas" id="notas" class="form-control" rows="3"></textarea>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <div class="your-order">
                                    <h3 class="title-7 margin-bottom-50">Tu pedido</h3>
                                    <div class="your-order-table table-responsive">

                                        <table class=" ">
                                            <thead>
                                            <tr>
                                                <th style="width: 50%;">Producto</th>
                                                <th >Precio</th>
                                                <th >Cantidad</th>
                                                <th >Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="item in carrito">
                                                    <td class="">
                                                        <span v-text="item.nombre"></span>
                                                    </td>
                                                    <td class="">
                                                        <span v-text="nfp(item.precio_venta)"></span>
                                                    </td>
                                                    <td class="">
                                                        <span v-text="item.cantidad"></span>
                                                    </td>
                                                    <td class="">
                                                        <span v-text="nfp(item.sub_total)"></span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th class=" order-total" colspan="3">Total Pedido</th>
                                                    <th class="order-total">
                                                        <span v-text="nfp(total)"></span>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>


                                        <div class="payment-method">
                                            <div class="payment-accordion">


                                                <template v-for="tipo in tipos_pago">
                                                    <h3 class="payment-accordion-toggle "  :id="'tipo_pago'+tipo.id" :data-value="tipo.id">
                                                        <span v-text="tipo.nombre"></span>
                                                    </h3>
                                                    <div class="payment-content">
                                                        <p v-text="tipo.descripcion"></p>
                                                    </div>
                                                </template>


                                            </div>
                                            <div class="order-button-payment">
                                                <input type="hidden" id="tipo_pago" name="tipo_pago" value="">
                                                <input type="submit" value="Realizar pedido" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Checkout-Billing-details and order end -->
            </div>
        </div>
        <!-- CHECKOUT-AREA END -->
    </section>
    <!-- PAGE-CONTENT END -->


@endsection


@push('scripts')
<script>
    const app = new Vue({
        el: '#pagar',
        created() {

        },
        mounted() {
            /*-------------------------
              accordion toggle function
            --------------------------*/
            $('.payment-accordion').find('.payment-accordion-toggle').on('click', function () {
                //Expand or collapse this panel
                $(this).next().slideToggle(500);
                //Hide the other panels
                $(".payment-content").not($(this).next()).slideUp(500);

            });
            /* -------------------------------------------------------
             accordion active class for style
            ----------------------------------------------------------*/
            $('.payment-accordion-toggle').on('click', function (event) {
                console.log('selecciona metodo')
                var id = $(this).data("value");

                $("#tipo_pago").val(id);

                $(this).siblings('.active').removeClass('active');
                $(this).addClass('active');
                event.preventDefault();
            });

            $('#tipo_pago1').click();
        },
        data: {
            tipos_pago : @json(\App\Models\TipoPago::all() ?? []),
            carrito:  @json(session('carrito')),
        },
        methods: {
            nfp(numero){
                return @json(dvs()) + number_format(numero,2);
            },
        },
        computed:{
            total(){
                var total=0;

                $.each(this.carrito,function (index,item) {
                    total+=parseFloat(item.sub_total);
                });

                return total;

            },
        }
    });
</script>
@endpush
