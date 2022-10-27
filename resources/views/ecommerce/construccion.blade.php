@extends('ecommerce.layout.app')

@section('htmlheader_title')
    En construcción
@endsection

@section('content')

    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col">
                    <h1 class="m-0 text-dark text-uppercase">
                        {{__('page under construction')}}
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container">

            <div class="py-0 text-center">
                <div class="row">
                    <div class="col-6">
                        <img src="{{asset('img/construccion.jpg')}}" class="img-fluid">

                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- /.content -->
@endsection

