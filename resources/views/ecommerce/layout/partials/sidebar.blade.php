<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">


    <!-- Sidebar -->
    <div class="sidebar" style="min-height: 70rem; margin-top: 0 !important;">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{getLogo()}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('home')}}" class="d-block">{{config('app.name')}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="{{route('home')}}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            {{__('Home')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{route('web.productos')}}" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            {{__('Productos')}}
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="{{route('web.categorias')}}" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            {{__('Categories')}}
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{route('web.marcas')}}" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            {{__('Brands')}}
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{route('web.about')}}" class="nav-link">
                        <i class="nav-icon fas fa-info"></i>
                        <p>
                            {{__('About')}}
                        </p>
                    </a>
                </li>
                @can('Panel administrativo')
                    <li class="nav-item ">
                        <a href="{{route('admin.home')}}" class="nav-link">
                            <i class="nav-icon fas fa-tools text-success"></i>
                            <p>
                                {{__('Admin')}}
                            </p>
                        </a>
                    </li>
                @endcan

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
