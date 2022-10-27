<div class="total-cart" id="carrito_navbar">
    <ul>
        <li>
            <a href="#">
                <span class="total-cart-number">
                    <span v-text="cantidad_articulos"></span>
                </span>
                <span><i class="sp-shopping-bag"></i></span>
            </a>
            <!-- Mini-cart-content Start -->
            <div class="total-cart-brief">
                <div class="cart-photo-details" v-for="item in items">
                    <div class="cart-photo">
                        <a :href="rutaFicha(item)"><img :src="item.miniatura" alt="" /></a>
                    </div>
                    <div class="cart-photo-brief">
                        <a :href="rutaFicha(item)" v-html="`${item.nombre}`"></a>
                        <br>
                        <span v-text="`${item.cantidad} x `">{{dvs()}} </span> <span v-text="item.precio_venta"></span>
                    </div>
                    <div class="pro-delete">
                        <button class="btn btn-outline-danger btn-sm rounded-circle "  @click.prevent="remover(item.id)">

                            <span v-show="eliminando!=item.id">
                                <i class="fa fa-circle-xmark"></i>
                            </span>
                            <span v-show="eliminando==item.id">
                                <i class="fas fa-sync fa-spin" ></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="cart-subtotal">
                    <p>Total = {{dvs()}} <span v-text="nfp(total)"></span></p>
                </div>
                <div class="cart-inner-btm">
                    <a href="{{route('carrito.index')}}">
                        {{__("Checkout")}}
                    </a>
                </div>
            </div>
            <!-- Mini-cart-content End -->
        </li>
    </ul>
</div>

@push('scripts')
<script>
    const VmCarritoNavBar = new Vue({
        name: 'carrito_navbar',
        el: '#carrito_navbar',
        created() {
            this.getDatos();

        },
        data: {
            items: [],
            agregando: false,
            eliminando: 0,
        },
        methods: {
            nfp(numero){
                return number_format(numero,2);
            },
            async getDatos(){
                logI('Get Datos VmCarritoNavBar');


                try {
                    let res = await axios.get(route('carrito.datos'));

                    this.items = res.data.data
                    logI(this.items);

                }catch (e) {
                    notifyErrorApi(e)

                }
            },
            async remover(itemId){

                this.eliminando = itemId;

                try {
                    let res = await axios.get(route('carrito.quitar',itemId));

                    iziTs(res.data.message);
                    this.eliminando = 0;
                    this.getDatos()


                }catch (e) {
                    this.eliminando = 0;
                    notifyErrorApi(e)

                }
            },
            rutaFicha(item){
                return route('productos.ficha',item.id);
            }
        },
        computed: {
            total(){
                var total=0;

                $.each(this.items,function (index,item) {
                    total+=parseFloat(item.sub_total);
                });

                return total;

            },
            cantidad_articulos(){
                var cant=0;
                $.each(this.items,function (index,item) {
                    cant=cant+parseInt(item.cantidad);
                });

                return cant;

            }
        },
        watch:{
            cantidad_articulos(){
                this.agregando = false;
            }
        }
    });
</script>
@endpush
