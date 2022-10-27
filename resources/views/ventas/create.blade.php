@extends('layouts.app')

@section('title_page','Nueva Venta')



@include('layouts.plugins.select2')
@include('layouts.xtra_condensed_css')
@include('layouts.plugins.bootstrap_datetimepicker')
@include('layouts.plugins.fancy_box')
@include('layouts.plugins.sweetalert2')

@push('sidebar_class','sidebar-collapse')

@push('css')
<style>
    .select2-dropdown {
        z-index: 1039;
    }
</style>
@endpush

@section('content')
    <div class="content-header pb-1 pt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">
                        Nueva Venta
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content" id="root">
        <div class="container-fluid">


            @include('layouts.errores')
            {!! Form::model($temporal, ['route' => ['ventas.update', $temporal->id], 'method' => 'patch']) !!}
            <div class="row mt-2">


                <!--Artículos-->
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="card card-info card-outline">
                        <div class="card-header with-border py-2">
                            <h3 class="card-title">
                                <strong>Artículos</strong>
                                <small class="text-muted text-md">
                                    (<i class="fas fa-cubes"></i>Stock)
                                    (<i class="fas fa-archive"></i>Ubicacion)
                                </small>
                            </h3>
                            <div class="card-tools pull-right">

                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                                <div class="form-group">
                                    <select-items
                                        api="{{route('api.items.index')}}"
                                        tienda="{{session('tienda')}}"
                                        v-model="itemSelect"
                                        ref="multiselect"
                                    >
                                    </select-items>
                                </div>



                                <div id="div-info-item"></div>

                            <div class="row pt-3">


                                <div class="form-group col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" data-toggle="tooltip" title="Cantidad">Cant</span>
                                        </div>
                                        <input
                                            v-model="editedItem.cantidad"
                                            type="number"
                                            min="0" step="any"
                                            class="form-control"
                                            ref="cantidad"
                                            @keydown.enter.prevent="siguienteCampo('precio')"
                                        >
                                    </div>
                                </div>

                                <div class="form-group  col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" data-toggle="tooltip" title="Precio venta">{{ dvs() }}</span>
                                        </div>
                                        <input
                                            v-model="editedItem.precio"
                                            type="number"
                                            min="0" step="any"
                                            ref="precio"
                                            class="form-control"
                                            placeholder="Precio compra"
                                            @keydown.enter.prevent="siguienteCampo('agregar')"
                                        >
                                        <span class="input-group-append">
                                                <button type="button" ref="agregar" class="btn btn-success" @click.prevent="save" :disabled="loading" >
                                                    <span v-show="loading" >
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                    </span>
                                                    <span v-show="!loading" class="glyphicon glyphicon-plus"></span>
                                                    Agregar
                                                </button>
                                            </span>
                                    </div><!-- /input-group -->

                                </div>
                            </div>


                            @include('ventas.tabla_det_vue')
                        </div>

                    </div>
                </div>
                <!--Artículos-->

                <!--Resumen-->
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                    <div class="card card-info card-outline">
                        <div class="card-header with-border py-2">
                            <h3 class="card-title">
                                <strong>
                                    Resumen
                                    {{--<small> iniciada: {{fechaHoraLtn($temporal->created_at)}}</small>--}}
                                </strong>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" style="padding: 0px;">


                            <ul class="list-group list-group-flush">
                                <!--            Clientes
                                ------------------------------------------------------------------------>
                                <li class="list-group-item p-1">
                                    <div class="form-group col-sm-12">
                                        <label for="clients" class="control-label">Cliente: <a class="success" data-toggle="modal" href="#modal-form-clientes" tabindex="1000">nuevo</a></label>
                                        {!!
                                                Form::select(
                                                    'cliente_id',
                                                    select(\App\Models\Cliente::class,'nombre_completo','id',null,null)
                                                    , null
                                                    , ['id'=>'clientes','class' => 'form-control','multiple','style'=>'width: 100%']
                                                )
                                            !!}
                                    </div>
                                </li>

                                <!--            Numero productos
                                ------------------------------------------------------------------------>
                                <li class="list-group-item pt-1 pb-1 text-bold">
                                    No. Productos:
                                    <span class="float-right" v-text="totalitems"></span>
                                </li>

                                <!--            Total
                                ------------------------------------------------------------------------>
                                <li class="list-group-item pt-1 pb-1 text-bold">

                                    Total
                                    <span class="float-right" >
            {{dvs()}} <span v-text="nfp(total)"></span>
        </span>

                                </li>

                                <!--            Vuelto
                                ------------------------------------------------------------------------>
                                <li class="list-group-item pt-1 pb-1 text-bold ">
                                    Vuelto
                                    <span class="float-right">
            {{dvs()}} <span v-text="nfp(vuelto)"></span>
        </span>
                                </li>



                            {{--<!--            Delivery--}}
                            {{-------------------------------------------------------------------------->--}}
                            {{--<li class="list-group-item pt-2 pb-1 text-bold ">--}}
                            {{--Delivery--}}
                            {{--<input type="hidden" name="delivery" :value="delivery ? 1 : 0">--}}
                            {{--<span class="float-right">--}}
                            {{--<toggle-button v-model="delivery"--}}
                            {{--:sync="true"--}}
                            {{--:labels="{checked: 'SI', unchecked: 'NO'}"--}}
                            {{--:height="30"--}}
                            {{--:width="60"--}}
                            {{--:value="false"--}}
                            {{--/>--}}
                            {{--</span>--}}
                            {{--</li>--}}

                            {{--<!--            Monto Delivery--}}
                            {{-------------------------------------------------------------------------->--}}
                            {{--<li class="list-group-item" v-show="delivery">--}}
                            {{--<div class="input-group">--}}
                            {{--<div class="input-group-prepend">--}}
                            {{--<div class="input-group-text">--}}
                            {{--Monto--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<input type="text" name="monto_delivery" id="" class="form-control" title="Costo Delivery" placeholder="Costo Delivery" v-model="abono_delivery">--}}
                            {{--</div>--}}
                            {{--</li>--}}



                            <!--            Tipo pago
    ------------------------------------------------------------------------>
                                <li class="list-group-item pl-2 pr-2">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="tipo_pago_id">Tipo Pago</label>
                                        </div>
                                        {!!
                                            Form::select(
                                                'tipo_pago_id',
                                                \App\Models\TipoPago::pluck('nombre', 'id')->toArray()
                                                , null
                                                , ['id'=>'tipo_pago_id','class' => 'custom-select']
                                            )
                                        !!}
                                    </div>

                                </li>

                                <!--            Observaciones
                                ------------------------------------------------------------------------>
                                <li class="list-group-item p-1">
                                    <div class="input-group">
                                    <textarea
                                        name="observaciones"
                                        id="observaciones"
                                        @focus="$event.target.select()"
                                        class="form-control"
                                        rows="2"
                                        placeholder="Observaciones"
                                    ></textarea>
                                    </div>
                                </li>

                                <!--            Recibido y procesar
                                ------------------------------------------------------------------------>
                                <li class="list-group-item p-0 pt-2">
                                    <div class="form-group col-sm-12">
                                        <label for="clients" class="control-label">Recibido: </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{dvs()}}</span>
                                            </div>
                                            <input type="text" name="recibido" id="recibido" v-model="recibido" @focus="$event.target.select()" class="form-control" placeholder="{{dvs()}} Recibido" data-toggle="tooltip" title="Doble Enter para procesar">
                                            <div class="input-group-append">
                                                <button type="submit"
                                                        id="btn-procesar"
                                                        name="procesar"
                                                        value="1"
                                                        class="btn btn-success"
                                                        :disabled="!habilitaProcesar"
                                                        data-loading-text="<i class='fa fa-cog fa-spin fa-1x fa-fw'></i> Procesando"
                                                        onClick="this.form.submit(); this.disabled=true;"
                                                >
                                                <span data-toggle="tooltip" title="Ingrese un monto mayor al total para procesar">

                                                <span class="glyphicon glyphicon-ok" ></span> Procesar
                                                </span>
                                                </button>
                                                <a class="btn btn-danger" data-toggle="modal" href="#modal-cancel-venta">
                                                    <span data-toggle="tooltip" title="Cancelar venta">X</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>


                            <div class="modal fade modal-warning" id="modal-cancel-venta">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Cancelar venta</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            Seguro que desea cancelar la venta?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                            <a href="{{route('ventas.cancelar',$temporal->id)}}" class="btn btn-danger">
                                                SI
                                            </a>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->




                        </div>
                    </div><!-- /.row -->

                </div>
                <!--/Resumen-->

            </div>
            {!! Form::close() !!}

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /.content -->

    @include('clientes.modal_form')
    @include('ventas.edit_modal_detalle')


@endsection


@push('scripts')
    <!--    Scripts ventas
------------------------------------------------->
    <script >

        vm = new Vue({
            el: '#root',
            mounted() {
                this.abreSelectorItems();
            },
            created: function() {
                this.getItems();
            },
            data: {
                itemSelect: null,

                detalles: [],

                editedItem: {
                    id : 0,
                    venta_id : @json($temporal->id),
                },
                defaultItem: {
                    id : 0,
                    venta_id : @json($temporal->id),
                    item_id: '',
                    cantidad: 0,
                    fecha_ven: '',
                    precio: 0,
                },

                loading: false,

                idEliminando: '',
                idEditando: '',
                recibido:0,
                descuento: 0
            },
            methods: {


                nfp: function(numero){
                    let decimales = parseInt(@json(config('app.cantidad_decimales_precio')));
                    return number_format(numero,decimales)
                },
                nf: function(numero){
                    let decimales = parseInt(@json(config('app.cantidad_decimales')));
                    return number_format(numero,decimales)
                },

                getId(item){
                    if(item)
                        return item.id;

                    return null
                },
                editItem (item) {
                    $("#"+this.id).modal('show');
                    this.editedItem = Object.assign({}, item);

                },
                close () {
                    $("#"+this.id).modal('hide');
                    this.loading = false;
                    setTimeout(() => {
                        this.editedItem = Object.assign({}, this.defaultItem);
                    }, 300)
                },

                async getItems () {

                    try {

                        let params= { params: {venta_id: @json($temporal->id) } }

                        var res = await axios.get(route('api.venta_detalles.index'),params);

                        this.detalles  = res.data.data;

                    }catch (e) {
                        notifyErrorApi(e);
                    }

                    this.loading = false;


                },
                async save () {

                    this.loading = true;


                    try {

                        this.editedItem.item_id = this.getId(this.itemSelect);
                        const data = this.editedItem;

                        if(this.editedItem.id === 0){

                            var res = await axios.post(route('api.venta_detalles.store'),data);

                        }else {

                            var res = await axios.patch(route('api.venta_detalles.update',this.editedItem.id),data);

                        }


                        iziTs(res.data.message);
                        this.editedItem = Object.assign({}, this.defaultItem);
                        this.abreSelectorItems();
                        this.getItems();

                    }catch (e) {
                        notifyErrorApi(e);
                        this.loading = false;
                    }

                },
                async deleteItem(item) {

                    this.idEliminando = item.id;
                    try{
                        let res = await  axios.delete(route('api.venta_detalles.destroy',item.id))
                        logI(res.data);

                        iziTs(res.data.message);
                        this.getItems();


                    }catch (e){
                        notifyErrorApi(e);
                        this.idEliminando = '';
                    }


                },

                abreSelectorItems () {
                    this.$refs.multiselect.$refs.multiselect.$el.focus();

                },
                siguienteCampo: function (campo){

                    if (campo=='agregar'){
                        $(this.$refs[campo]).focus().select();
                    }else {

                        $(this.$refs[campo]).focus().select();
                    }
                },
            },
            computed: {
                dvs: function(){
                    return @json(dvs())
                },
                total: function () {
                    var t=0;

                    $.each(this.detalles,function (i,det) {
                        t+=det.sub_total;
                    });

                    return t;
                },

                totalitems: function () {
                    var t=0;
                    $.each(this.detalles,function (i,det) {
                        t+=(det.cantidad*1);
                    });

                    return t;
                },
                vuelto: function () {
                    let total = parseFloat(this.total);
                    let recibido= parseFloat(this.recibido);


                    if (recibido > 0){
                        return recibido - total;
                    }

                    return 0;

                },
                habilitaProcesar: function () {

                    return (this.total>0 && this.recibido>=this.total)

                }
            },
            watch: {
                itemSelect (item) {

                    if (item){

                        this.editedItem.precio = item.precio_venta;
                        this.editedItem.item_id = item.id;
                        $(this.$refs.cantidad).focus().select();
                    }else{
                        this.editedItem = Object.assign({}, this.itemDefault);
                    }
                },
            }
        });

        $(function () {


            $("#recibido").keypress(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    $("#btn-procesar").focus();
                }
            });

            $('#clientes').select2({
                language: 'es',
                maximumSelectionLength: 1,
                allowClear: true
            }).on('change',function (e) {

            });

            $("#btn-procesar").click(function () {
                $(this).button('loading');
            });


        })
    </script>
@endpush
