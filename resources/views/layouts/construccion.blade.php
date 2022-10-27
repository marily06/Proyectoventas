@extends('layouts.app')

@section('title_page')
    En construcción
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1 class="m-0 text-dark">{{__('page under construction')}}</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">


            <!-- Info boxes -->
            <div class="row">
                <div class="col-lg-12 col-12 mb-3">
                    <div class="card ">
                        <!-- /.card-header -->
                        <div class="card-body text-center">
                            <img src="{{asset('img/construccion.jpg')}}" class="img-fluid" style="max-width: 40%">
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

