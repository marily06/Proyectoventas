<script>
    $(function () {
        function formatStateItems (state) {

            var $state = $(
                    "@component('components.format_slc2_item')"+
                    "@slot('imagen')"+state.imagen+ "@endslot"+
                    "@slot('nombre')"+state.nombre+ "@endslot"+
                    "@slot('descripcion')"+ state.descripcion+"@endslot"+
                    "@slot('um')"+ state.um+"@endslot"+
                    "@endcomponent"
            );

            return $state;
        };


        $.fn.defSelect2=function(){
            $(this).select2({
                language : 'es',
                ajax: {
                    url: "{{ route('api.items.index') }}",
                    dataType: 'json',
                    data: function (params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function (data, params) {

                        return {
                            results: data.data,
                        };
                    },
                    cache: true
                },
                //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                minimumInputLength: 1,
                templateResult: formatStateItems,
                templateSelection: function(data,contenedor) {
                    if(data.id === '')
                        return 'Ingrese descripcion';

                    var fila= contenedor.closest("tr");
                    fila.find(".codigo").val(data.codigo);
                    fila.find(".precio").focus().select();
                    return data.nombre;
                }

            });
        };
    })
</script>