<div class="form-row" id="campos_item">

    <div class="form-group col-sm-12">
        <span class="text-danger">(*)</span> Campos obligatorios
    </div>
    <div class="form-group col-sm-5">
        <div class="row">
            <!-- Imagen Field -->
            <div class="form-group col-sm-12 ">
                {!! Form::label('imagen', 'Imagen:') !!}
                {!! Form::file('imagen', ['class' => 'form-control file']) !!}
            </div>
        </div>
    </div>

    <div class="form-group col-sm-7">
        <div class="row">

            <!-- Codigo Field -->
            <div class="form-group col-sm-3" >
                {!! Form::label('codigo', 'Codigo:') !!}
                {!! Form::text('codigo', null, ['class' => 'form-control','autofocus']) !!}
                {!! Form::hidden('iestado_id', 1) !!}
            </div>

            <!-- Nombre Field -->
            <div class="form-group col-sm-9" >

                {!! Form::label('nombre', 'Nombre: ') !!}
                <span class="text-danger"> *</span>
                @if((isset($item) && !$item->puedeEditarNombre()))
                    <span class="text-sm text-warning">
                        <strong>El artículo esta registrado en una compra o requisición</strong>
                    </span>
                @endif
                {!! Form::text('nombre', null, [
                        'class' => 'form-control',
                        $item->puedeEditarNombre() ? '' : 'readonly'
                    ]) !!}
            </div>

            <!-- Stock Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('stock', 'Existencias:') !!}<span class="text-danger"> *</span>
                {!! Form::number('stock', $item->stock , ['class' => 'form-control',$item->puedeEditarNombre() ? '' : 'readonly']) !!}
            </div>

            <!-- Precio Venta Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('precio_venta', 'Precio Venta:') !!}<span class="text-danger"> *</span>
                {!! Form::number('precio_venta', null, ['class' => 'form-control','step'=>".01"]) !!}
            </div>

        <!-- Precio Compra Field -->
            <div class="form-group col-sm-4">
                {!! Form::label('precio_compra', 'Precio Compra:') !!}<span class="text-danger"> *</span>
                {!! Form::number('precio_compra', null, ['class' => 'form-control','step'=>".01"]) !!}
            </div>

            <!-- Icategoria Id Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('icatecoria_id','Categorias: ') !!}
                <a class="success" data-toggle="modal" href="#modal-form-icategorias" tabindex="1000">Nueva</a>
                {!!
                    Form::select(
                        'categorias[]',
                        select(\App\Models\ItemCategoria::class,'nombre','id',null)
                        , $categoriasItem ?? null
                        , ['id'=>'icatecorias','class' => 'form-control ','multiple','style'=>'width: 100%']
                    )
                !!}
            </div>

        </div>

    </div>


    <div class="form-group col-sm-12"  >
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Información adicional</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <!-- Descripcion Field -->
                        <div class="form-group col-sm-12 col-lg-12">
                            {!! Form::label('descripcion', 'Descripcion:') !!}
                            {!! Form::textarea('descripcion', null, ['id' => 'editor','class' => '']) !!}
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <div class="row">

                            <!-- Unimed Id Field -->
                            <div class="form-group col-sm-6">
                                <select-unimed v-model="unimed" label="Unidad de medida"></select-unimed>
                            </div>

                            <!-- Marca Id Field -->
                            <div class="form-group col-sm-6">
                                <select-marca v-model="marca" label="Marca"></select-marca>
                            </div>

                            <!-- Ubicacion Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::label('ubicacion', 'Ubicacion:') !!}
                                {!! Form::text('ubicacion', null, ['class' => 'form-control']) !!}
                            </div>


                            <!-- inventariable Field -->
                            <div class="form-group col-xs-6 col-sm-3">
                                {!! Form::label('inventariable', 'Inventariable:') !!}
                                <div style="width: 100%">
                                    <input type="hidden" name="inventariable" value="0">
                                    <input type="checkbox"
                                           data-toggle="toggle"
                                           data-size="normal"
                                           data-on="Si"
                                           data-off="No"
                                           data-style="ios"
                                           name="inventariable"
                                           value="1"
                                        {{ ($item->inventariable ?? true ) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Perecedero Field -->
                            <div class="form-group col-xs-6 col-sm-3">
                                {!! Form::label('perecedero', 'Perecedero:') !!}
                                <div style="width: 100%">
                                    <input type="hidden" name="perecedero" value="0">
                                    <input type="checkbox"
                                           data-toggle="toggle"
                                           data-size="normal"
                                           data-on="Si"
                                           data-off="No"
                                           data-style="ios"
                                           name="perecedero"
                                           value="1"
                                        {{ ($item->perecedero ?? true ) ? 'checked' : '' }}>
                                </div>
                            </div>

                            <!-- Perecedero Field -->
                            <div class="form-group col-xs-6 col-sm-3">
                                {!! Form::label('portada', 'Portada:') !!}
                                <div style="width: 100%">
                                    <input type="hidden" name="portada" value="0">
                                    <input type="checkbox"
                                           data-toggle="toggle"
                                           data-size="normal"
                                           data-on="Si"
                                           data-off="No"
                                           data-style="ios"
                                           name="portada"
                                           value="1"
                                        {{ ($item->portada ?? true ) ? 'checked' : '' }}>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>

</div>

@push('css')
    <style>
        .ck.ck-editor {
            max-width: 100%;
            max-height: 500px;
        }
        .ck-editor__editable
        {
            min-height: 11rem !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                removePlugins: [ 'Heading', 'Link' ],
                toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote' ],
                minHeight: '800px'
            } )
            .catch( error => {
                console.log( error );
            } );
    </script>
    <script>
        $(function () {
            $("#categorias").select2({
                language: "es",
                placeholder: 'Seleccione uno...',
//            maximumSelectionLength: 1,
                allowClear: true
            })

            $("#icatecorias").select2({
                placeholder: 'Seleccione una...',
                language: "es",
                allowClear: true

            });

            $("input[type=text]").focus(function() {
                $(this).select();
            });
        })

        new Vue({
            el: '#campos_item',
            name: 'campos_item',
            mounted() {
                console.log('Instancia vue montada');
            },
            created() {
                console.log('Instancia vue creada');
            },
            data: {
                marca : @json($item->marca ?? \App\Models\Marca::find(old('marca_id')) ?? null),
                unimed : @json($item->unimed ?? \App\Models\Marca::find(old('unimed_id')) ?? null),
            },
            methods: {
                getDatos(){
                    console.log('Metodo Get Datos');
                }
            }
        });
    </script>
@endpush
