@extends('layouts.app')

@section('title_page','Compra o Ingreso')


@include('layouts.plugins.select2')
@include('layouts.xtra_condensed_css')
@include('layouts.plugins.bootstrap_fileinput')
@push('sidebar_class','sidebar-collapse')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header pb-1 pt-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">
                        Nueva Compra o Ingreso
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content" id="root">
        <div class="container-fluid">


            @include('layouts.errores')

            {!! Form::model($temporal, ['route' => ['compras.update', $temporal->id], 'method' => 'patch']) !!}
            <div class="row mt-2">

                    <!-- Articulos -->
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="card card-warning card-outline">
                            <div class="card-header with-border py-2">
                                <h3 class="card-title">
                                    <strong>Artículos</strong>
                                    <small class="text-muted text-md">
                                        (<i class="fas fa-cubes"></i>Stock)
                                        (<i class="fas fa-archive"></i>Ubicacion)
                                    </small>
                                </h3>
                                <div class="card-tools pull-right">
                                    {{--<button class="btn btn-tool" data-widget="collapse" tabindex="1000"><i class="fa fa-minus"></i></button>--}}
                                    {{--<button class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group mb-4">
                                    <select-items
                                        api="{{route('api.items.index')}}"
                                        tienda="1"
                                        v-model="itemSelect"
                                        ref="multiselect"
                                    >
                                    </select-items>
                                </div>

                                <div class="row pt-3">

                                    <div class="form-group col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" data-toggle="tooltip" title="Fecha Vence">
                                                    Fecha Vence
                                                </span>
                                            </div>
                                            <input
                                                v-model="editedItem.fecha_ven"
                                                type="date"
                                                class="form-control"
                                                @keydown.enter.prevent="siguienteCampo('cantidad')"
                                            >
                                        </div>
                                    </div>

                                    <div class="form-group col-xs-12 col-sm-3 col-md-3 col-lg-3">
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

                                    <div class="form-group  col-xs-12 col-sm-5 col-md-5 col-lg-5">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" data-toggle="tooltip" title="Precio compra">{{ dvs() }}</span>
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

                                <div id="div-info-item"></div>

                                @include('compras.tabla_det_vue')
                            </div>
                        </div>
                    </div>
                    <!-- /. Articulos -->

                    <!-- Resumen -->
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="card card-warning card-outline">
                            <div class="card-header py-2">
                                <h3 class="card-title">
                                    <strong>
                                        Resumen
                                        {{--<small>iniciada: {{fechaHoraLtn($temporal->created_at)}}</small>--}}
                                    </strong>
                                </h3>
                                <div class="card-tools pull-right">
                                    {{--<button class="btn btn-tool" data-widget="collapse" tabindex="1000"><i class="fa fa-minus"></i></button>--}}
                                    {{--<button class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="padding: 0px;">

                                @include('compras.fields')

                            </div>
                        </div><!-- /.row -->
                    </div>
                    <!-- /. Resumen -->


{{--                @include('ventas.edit_modal_detalle')--}}
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->


@endsection

@push('scripts')
    <!--    Scripts compras
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
                    compra_id : @json($temporal->id),
                },
                defaultItem: {
                    id : 0,
                    compra_id : @json($temporal->id),
                    item_id: '',
                    cantidad: 0,
                    fecha_ven: '',
                    precio: 0,
                },
                loading: false,

                idEliminando: '',
                ingreso_inmediato: false,

                fecha_ingreso_plan: "{{hoyDb() ?? old('fecha_ingreso_plan')}}",

                proveedor: @json($compra->proveedor ?? \App\Models\Proveedor::find(old('proveedor_id')) ?? null),
                tipo: @json($compra->tipo ?? \App\Models\CompraTipo::find(old('tipo_id')) ?? null),

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

                        let params= { params: {compra_id: @json($temporal->id) } }

                        var res = await axios.get(route('api.compra_detalles.index'),params);

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

                            var res = await axios.post(route('api.compra_detalles.store'),data);

                        }else {

                            var res = await axios.patch(route('api.compra_detalles.update',this.editedItem.id),data);

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
                        let res = await  axios.delete(route('api.compra_detalles.destroy',item.id))
                        logI(res.data);

                        iziTs(res.data.message);
                        this.getItems();


                    }catch (e){
                        notifyErrorApi(e);
                        this.idEliminando = '';
                    }


                },

                procesar: function () {
                    if(this.totalitems>=1){
                        $('#modal-confirma-procesar').modal('show');
                    }else {
                        iziTe('No hay ningún artículo en este ingreso')
                    }
                },
                siguienteCampo: function (campo){

                    if (campo=='agregar'){
                        $(this.$refs[campo]).focus().select();
                    }else {

                        $(this.$refs[campo]).focus().select();
                    }
                },
                abreSelectorItems () {
                    this.itemSelect = null;
                    this.$refs.multiselect.$refs.multiselect.$el.focus();

                }
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

                esFactura(){
                    if (this.tipo){
                        return this.tipo.id= @json(\App\Models\CompraTipo::FACTURA)
                    }

                    return false;
                }
            },
            watch:{
                ingreso_inmediato(val){
                    if(val){
                        this.fecha_ingreso_plan = '{{hoyDb()}}'
                    }

                },
                itemSelect (item) {

                    if (item){

                        this.editedItem.precio = item.precio_compra;
                        this.editedItem.item_id = item.id;
                        $(this.$refs.cantidad).focus().select();
                    }else{
                        this.editedItem = Object.assign({}, this.itemDefault);
                    }
                },
            }

        });
    </script>
@endpush
