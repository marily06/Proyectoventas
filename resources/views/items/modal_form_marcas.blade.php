<div class="modal fade" id="modal-form-marcas">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" role="form" id="form-modal-marcas">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Nueva Marca</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <!-- Nombre Field -->
                            <div class="form-group col-sm-12">
                                {!! Form::label('nombre', 'Nombre:') !!}
                                {!! Form::text('nombre', '', ['class' => 'form-control']) !!}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="myButton" data-loading-text="Loading..." class="btn btn-primary" autocomplete="off">
                        Guardar
                    </button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
@include('layouts.bootstrap_alert_float')
<script>
    $("#form-modal-marcas").submit(function (e) {
        e.preventDefault();
        console.log('enviar formulario modal marcas');

        var data= $(this).serializeArray();

        var $btn = $('#myButton').button('loading');

        $.ajax({
            method: 'POST',
            url: '{{route("api.marcas.store")}}',
            data: data,
            dataType: 'json',
            success: function (res) {
                console.log('respuesta ajax:',res)
                if(res.success){
                    var option = new Option(res.data.nombre, res.data.id);
                    option.selected = true;

                    //quita la marcas seleccionado y agrega el nuevo
                    $("#marcas option:selected").attr("selected", false);
                    $("#marcas").append(option).trigger("change");

                    $('#modal-form-marcas').modal('hide');

                    iziTs(res.message);
                }else{

                }

                $btn.button('reset');
            },
            error: function (res) {
                console.log('respuesta ajax:',res.responseJSON);
                iziTe('<strong>Error! </strong>'+res.responseJSON.message);
                $btn.button('reset');
            }
        })
    });


</script>
@endpush