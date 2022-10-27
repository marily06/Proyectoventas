@section('css')
    @include('layouts.datatables_css')
@endsection

<div class="table-responsive">
    {!! $dataTable->table(['width' => '100%']) !!}
</div>

{{--<div class="row">--}}
{{--    <div class="col">--}}
{{--        <span class="badge badge-danger">Vencidas</span>--}}
{{--        <span class="badge badge-warning">Hoy Vencen</span>--}}
{{--    </div>--}}
{{--</div>--}}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
        $(function () {
            var dt = LaravelDataTables["dataTableBuilder"];

            //Cuando dibuja la tabla
            dt.on( 'draw.dt', function () {
                $(this).addClass('table-sm table-striped table-bordered table-hover');
                $(this).find('tbody').addClass('text-sm');
                $(this).find('thead').addClass('text-sm');

                $('[data-toggle="tooltip"]').tooltip();


                var totalRegistros= dt.ajax.json().count_rows;

                $("#total_deuda").text(dt.ajax.json().total);
                $("#count_rows").text(totalRegistros);
                $("#total_filtro").text(dt.ajax.json().totalFilter);
            });


        })
    </script>
@endsection
