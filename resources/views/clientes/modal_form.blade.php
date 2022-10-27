<!-- Modal form create clientes -->
<div class="modal fade" id="modal-form-clientes">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" role="form" id="form-modal-clientes">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Nuevo cliente
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        @include('clientes.fields')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnSubmitFormClientes" data-loading-text="Guardando..." class="btn btn-primary" autocomplete="off">
                        Guardar
                    </button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /. Modal form create clientes -->

@push('scripts')
<!--    Scripts modal form create clientes
------------------------------------------------->
<script>

    //Cuando el modal se abre
    $('#modal-form-clientes').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Boton que abrió el modal
        var select2target = button.closest('div').find('select');


        //Envío del formulario del modal
        $("#form-modal-clientes").submit(function (e) {
            e.preventDefault();

            var data= $(this).serializeObject();

            console.log('enviar formulario select2target: '+select2target.attr('id'),data);

            $('#btnSubmitFormClientes').button('loading');

            var url = "{{route("api.clientes.store")}}";

            axios.post(url,data).then(response => {
                var data = response.data.data;
                var msg = response.data.message;

                console.log('respuesta ajax:',data);

                var option = new Option(data.full_name, data.id);
                option.selected = true;

                //quita la opción seleccionada del select objetivo
                select2target.find('option:selected').attr("selected", false);
                //Cambia la opción del select objetivo por la creada
                select2target.empty().append(option).trigger("change");

                
                $('#modal-form-clientes').modal('hide'); 

                iziTs(msg);

                $('#btnSubmitFormClientes').button('reset');
                 
                $("#form-modal-clientes")[0].reset();
            })
            .catch(error => {
                console.log(error.response);
                $('#btnSubmitFormClientes').button('reset');
                $("#form-modal-clientes")[0].reset();
                iziTe(erroresToList(error.response.data.errors))
            });


        });
        //Envío del formulario del modal

    });

    //Cuando el modal se cierra
    $('#modal-form-clientes').on('hidden.bs.modal', function (event) {

        //Elimina los eventos del formulario
        $("#form-modal-clientes").unbind();
    });
</script>
@endpush
