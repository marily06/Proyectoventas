<!-- Modal sbitacoras -->
<div class="modal fade" id="modalEditDetalle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" v-on:submit.prevent="updateDet(detalleEdita.id)">

                <div class="modal-header">
                    <h5 class="modal-title">Editar detalle </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <!-- Titulo Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('titulo', 'Cantidad:') !!}
                            <input type="text"  class="form-control" required="required" v-model="detalleEdita.cantidad">

                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('titulo', 'Precio:') !!}
                            <input type="text"  class="form-control" required="required" v-model="detalleEdita.precio">

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" data-loading-text="Loading..." class="btn btn-primary" autocomplete="off" :disabled="loadingBtnUpdateDet">
                        <i  v-show="loadingBtnUpdateDet" class="fa fa-spinner fa-spin"></i> Guardar
                    </button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /. Modal sbitacoras -->