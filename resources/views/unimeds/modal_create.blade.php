<!-- Modal unimeds -->
<div class="modal fade" id="modal-form-unimeds">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" role="form" id="form-modal-unimeds">

                <div class="modal-header">
                    <h4 class="modal-title">Nueva Unidad De medida</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            @include('unimeds.fields')
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit"  data-loading-text="Loading..." class="btn btn-primary" autocomplete="off">
                        Guardar
                    </button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /. Modal unimeds -->

@push('scripts')
<!--    Scripts modal form unimeds
------------------------------------------------->
<script>

    //Cuando el modal se abre
    $('#modal-form-unimeds').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Boton que abrió el modal
        var select2target = button.closest('div').find('select');


        //Envío del formulario del modal
        $("#form-modal-unimeds").submit(function (e) {
            e.preventDefault();

            console.log('enviar formulario modal marcas select2target: '+select2target.attr('id'));

            var data= $(this).serializeArray();

            var $btn = $(this).find(':submit').button('loading');

            $.ajax({
                method: 'POST',
                url: '{{route("api.unimeds.store")}}',
                data: data,
                dataType: 'json',
                success: function (res) {
                    console.log('respuesta ajax:',res)
                    if(res.success){
                        var option = new Option(res.data.nombre, res.data.id);
                        option.selected = true;

                        //quita la opción seleccionada del select objetivo
                        select2target.find('option:selected').attr("selected", false);
                        //Cambia la opción del select objetivo por la creada
                        select2target.append(option).trigger("change");

                        //Ocultar el modal
                        $('#modal-form-unimeds').modal('hide');

                        iziTs(res.message);
                    }

                    $btn.button('reset');
                },
                error: function (res) {
                    console.log('respuesta ajax:',res.responseJSON);
                    iziTe(erroresToList(res.responseJSON.errors));
                    $btn.button('reset');
                }
            })
        });
        //Envío del formulario del modal

    });

    //Cuando el modal se cierra
    $('#modal-form-unimeds').on('hidden.bs.modal', function (event) {

        //Elimina los eventos del formulario
        $("#form-modal-unimeds").unbind();
    });
</script>
@endpush