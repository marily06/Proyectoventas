<!-- Modal form create icategorias -->
<div class="modal fade" id="modal-form-icategorias">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" role="form" id="form-modal-icategorias">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Nuevo icategoria
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        @include('item_categorias.fields')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnSubmitFormIcategorias" data-loading-text="Guardando..." class="btn btn-primary" autocomplete="off">
                        Guardar
                    </button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /. Modal form create icategorias -->

@push('scripts')
<!--    Scripts modal form create icategorias
------------------------------------------------->
<script>

    //Cuando el modal se abre
    $('#modal-form-icategorias').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Boton que abrió el modal
        var select2target = button.closest('div').find('select');


        //Envío del formulario del modal
        $("#form-modal-icategorias").submit(function (e) {
            e.preventDefault();

            var data= $(this).serializeObject();

            console.log('enviar formulario select2target: '+select2target.attr('id'),data);

            $('#btnSubmitFormIcategorias').button('loading');

            var url = "{{route("api.item_categorias.store")}}";

            axios.post(url,data).then(response => {
                var data = response.data.data;
                var msg = response.data.message;

                logI('respuesta ajax: ',data);

                var option = new Option(data.nombre, data.id);
                option.selected = true;

                //quita la opción seleccionada del select objetivo
                select2target.find('option:selected').attr("selected", false);
                //Cambia la opción del select objetivo por la creada
                select2target.append(option).trigger("change");


                $('#modal-form-icategorias').modal('hide');

                iziTs(msg);

                $('#btnSubmitFormIcategorias').button('reset');

                $("#form-modal-icategorias")[0].reset();
            })
            .catch(error => {

                if(error.response){
                    logI('respuesta ajax: '+error.response.data);

                    $("#form-modal-icategorias")[0].reset();
                    iziTe(erroresToList(error.response.data.errors))
                }else {
                    logI(error);
                }

                $('#btnSubmitFormIcategorias').button('reset');
            });


        });
        //Envío del formulario del modal

    });

    //Cuando el modal se cierra
    $('#modal-form-icategorias').on('hidden.bs.modal', function (event) {

        //Elimina los eventos del formulario
        $("#form-modal-icategorias").unbind();
    });
</script>
@endpush
