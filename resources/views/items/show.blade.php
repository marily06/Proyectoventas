@extends('layouts.app')

@section('title_page')
    Artículo
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Artículo</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row" >
                                <div class="col-sm-6" align="center">
                                    <img src="{{$item->img}}" class="img-fluid" alt="Image">
                                    <div class="col-12 product-image-thumbs">
                                    @foreach($item->media as $i => $img)
                                        <div class="product-image-thumb p-1" >
                                            <img src="{{asset($img->getUrl())}}" alt="{{$item->nombre}}" @click="changeImg('{{asset($img->getUrl())}}')">
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    @include('items.show_fields')
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                    <a href="{!! route('items.index') !!}" class="btn btn-default">Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
