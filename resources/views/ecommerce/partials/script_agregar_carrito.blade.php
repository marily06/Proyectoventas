@push('scripts')

    <!--            Scripts agregar item carrito
    ------------------------------------------------------------------------>
    <script>
        new Vue({
            el: '#agregar_items_vue',
            name: 'agregar_items_vue',
            created() {


            },
            data: {

                detalles: [],


                cantidad: 1,
                loading: false,
            },
            methods: {

                async agregarCarro (itemId) {

                    this.loading = true;


                    try {

                        var res = await axios.post(route('carrito.agregar',{'item_id' : itemId,cantidad: this.cantidad}));

                        logI(res.data);

                        iziTs(res.data.message);
                        this.loading = false;
                        VmCarritoNavBar.getDatos();

                    }catch (e) {
                        notifyErrorApi(e);
                        this.loading = false;
                    }

                },


            },
            computed: {

            },
            watch: {

            }
        });

    </script>
@endpush
