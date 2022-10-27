<!-- Modal form create items -->
<div class="modal fade" id="modal-form-items">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="post" role="form" id="form-modal-items" enctype="multipart/form-data">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Nuevo item
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        @include('items.fields')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnSubmitFormItems" data-loading-text="Guardando..." class="btn btn-primary" autocomplete="off">
                        Guardar
                    </button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /. Modal form create items -->

@push('scripts')
<!--    Scripts modal form create items
------------------------------------------------->
<script>

    //Cuando el modal se abre
    $('#modal-form-items').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Boton que abrió el modal
        var select2target = button.closest('div').find('select');


        //Envío del formulario del modal
        $("#form-modal-items").submit(function (e) {
            e.preventDefault();

            var data= $(this).serializeObject();


            console.log('enviar formulario select2target: '+select2target.attr('id'),data);

            $('#btnSubmitFormItems').button('loading');

            var url = "{{route("api.items.store")}}";

            axios.post(url,data).then(response => {
                logI('respuesta ajax:',response);

                var data = response.data.data;
                var msg = response.data.message;


                var option = new Option(data.text, data.id, true, true);

                select2target.empty().trigger('change');
                select2target.append(option).trigger('change');

                // manually trigger the `select2:select` event
                select2target.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });


                $('#modal-form-items').modal('hide');

                iziTs(msg);

                $('#btnSubmitFormItems').button('reset');

                $("#form-modal-items")[0].reset();
            })
            .catch(error => {
                console.log(error.response);
                $('#btnSubmitFormItems').button('reset');
                // $("#form-modal-items")[0].reset();
                iziTe(erroresToList(error.response.data.errors))
            });


        });
        //Envío del formulario del modal

    });

    //Cuando el modal se cierra
    $('#modal-form-items').on('hidden.bs.modal', function (event) {

        //Elimina los eventos del formulario
        $("#form-modal-items").unbind();

        $('#fv-new-det').focus().select();

    });
</script>
@endpush
