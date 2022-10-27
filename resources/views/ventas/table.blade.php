@section('css')
    @include('layouts.datatables_css')
@endsection

<div class="table-responsive">
    {!! $dataTable->table(['width' => '100%']) !!}
</div>

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
        $(function () {


            var dt = LaravelDataTables["dataTableBuilder"];

            //Cuando dibuja la tabla
            dt.on( 'draw.dt', function () {
                $(this).addClass('table-sm table-striped table-bordered table-hover');

                $('[data-toggle="tooltip"]').tooltip();

                var totalRegistros= dt.ajax.json().count_rows;


                $("#count_rows").text(totalRegistros);
                $("#total_deuda").text(dt.ajax.json().total);
                $("#total_filtro").text(dt.ajax.json().totalFilter);
            });


        })
    </script>
@endsection
