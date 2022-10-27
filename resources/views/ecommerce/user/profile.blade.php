@extends('ecommerce.layout.app')

@section('htmlheader_title',__('Profile'))

@push('css')
    <style>

        .icon-edit-avatar{
            position: absolute;
            right:20px;
            top:10px;
            text-align: center;
            border-radius: 30px 30px 30px 30px;
            color:white;
            padding:5px 10px;
            font-size:20px;
        }
    </style>
@endpush

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{__('Profile')}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container">

            @include('layouts.partials.request_errors')

            <div class="row">
                <div class="col-md-3">

                    <!-- Modal -->
                    <div class="modal fade" id="modalRemoveAvatar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="modelTitleId">
                                        Eliminar Avatar
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Esta seguro?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">NO</button>
                                    <a class="btn btn-success " href="{{route('web.profile.remove.avatar',auth()->user()->id)}}">
                                        SI
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile pb-1">
                            <div class="text-center box-img-profile" >
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{Auth::user()->img}}"
                                     alt="User profile picture">

                                <!-- Modal -->



                                <div class="dropdown open icon-edit-avatar" >
                                    <button class="btn  " type="button" id="triggerId"
                                            data-toggle="dropdown" >
                                        <i class="fa fa-camera text-primary" style="font-size: 1.5rem"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="triggerId">
                                        <input id="upload" type="file" style="display: none"/>
                                        <button class="dropdown-item" href="#" id="upload_link">
                                            {{__('Upload your photo')}}
                                        </button>
                                        <button type="button" class="dropdown-item " data-toggle="modal" data-target="#modalRemoveAvatar">
                                            {{__('Remove photo')}}
                                        </button>

                                    </div>
                                </div>

                                <div class="modal fade" id="modal-edit-avatar" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">
                                                    {{__('Crop your new profile picture')}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="img-container">
                                                    <img id="imgNewAvatar" src="{{auth()->user()->img}}" alt="Picture" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-success " id="set_new_profile_pictur">
                                                    {{__('Set new profile picture')}}
                                                </button>
                                                <div class="spinner-border text-success" role="status" id="uploadaAvatarSpinner" style="display: none">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

                            <p class="text-muted text-center">
                                <a class="text-center" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
{{--                                <li class="list-group-item">--}}
{{--                                    <b>Ventas Promedio/día</b>--}}
{{--                                    <span class="float-right">--}}
{{--                                        {{auth()->user()->ventas_promedio}}--}}
{{--                                    </span>--}}
{{--                                </li>--}}
                            </ul>

{{--                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>--}}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">{{__('Data')}}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">{{__('Activity')}}</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane active" id="settings">
                                    {!! Form::model($profile, ['route' => ['web.profile.update', $profile->id], 'method' => 'patch']) !!}

                                    <div class="form-group row">
                                        {!! Form::label('username', __('Username'),["class"=>"col-sm-2 col-form-label"]) !!}
                                        <div class="col-10">
                                            {!! Form::text('username', null, ['class' => 'form-control','readonly']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                            {!! Form::label('name', __('Name'),["class"=>"col-sm-2 col-form-label"]) !!}
                                            <div class="col-10">
                                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('email', __('Email'),["class"=>"col-sm-2 col-form-label"]) !!}
                                            <div class="col-10">
                                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                            </div>
                                        </div>

{{--                                        <div class="form-group row">--}}
{{--                                            <div class="offset-sm-2 col-sm-10">--}}
{{--                                                <div class="checkbox">--}}
{{--                                                    <label>--}}
{{--                                                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>--}}
{{--                                                    </label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            @foreach(auth()->user()->roles as $rol)
                                                <span class="badge badge-primary">
                                                    {{$rol->name}}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-outline-success">{{__('Submit')}}</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="activity">

                                </div>
                                <!-- /.tab-pane -->


                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@push('scripts')
    <script>
        $(function(){

            //para abrir el imput tipo file
            $("#upload_link").on('click', function(e){
                e.preventDefault();
                $("#upload:hidden").trigger('click');
            });


            //después de seleccionar el archivo (carga la imagen en el modal y lo abre)
            $("#upload").change(function () {

                if (this.files && this.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#imgNewAvatar').attr('src', e.target.result);
                        $("#modal-edit-avatar").modal('show');
                    }

                    reader.readAsDataURL(this.files[0]);
                }

            });

            var cropBoxData;
            var canvasData;
            var cropper;



            //Cuando el modal se abre (inicializa el plugin para recortar la imagen)
            $('#modal-edit-avatar').on('shown.bs.modal', function () {

                var image = document.getElementById('imgNewAvatar');

                cropper = new Cropper(image, {
                    autoCropArea: 1,
                    ready: function () {
                        //Should set crop box data first here
                        cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                    }
                });
            }).on('hidden.bs.modal', function () {
                cropBoxData = cropper.getCropBoxData();
                canvasData = cropper.getCanvasData();
                cropper.destroy();
            });


            $("#set_new_profile_pictur").click(function (e) {

                e.preventDefault();

                $("#uploadaAvatarSpinner").show();


                cropper.getCroppedCanvas().toBlob(function (blob) {

                    const formData = new FormData();
                    const extension = blob.type.split('/')[1];
                    const imageFile = new File([blob], `${Date.now()}.${extension}`, {
                        type: blob.type,
                    });

                    formData.append('avatar', imageFile);
                    console.log(blob,formData);

                    const header = {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    };

                    const url = '{{route('web.profile.edit.avatar',auth()->user()->id)}}';

                    axios.post(url,formData,header)
                    .then(response => {
                        log(response);

                        $("#modal-edit-avatar").modal('hide');
                        location.reload();
                    })
                    .catch(error => {
                        log(error.response);
                    });


                });
            })

        });
    </script>
@endpush
