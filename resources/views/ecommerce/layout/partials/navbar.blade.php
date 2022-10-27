<!-- HEADER-AREA START -->
<header class="header-area">
    <!-- Header-Top Start -->
    <div class="header-top d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="header-top-left text-start">
                        <ul>
                            <li>
                                <i class="sp-phone"></i>
                                <span>{{getPbx()}}</span>
                            </li>
                            <li>
                                <i class="sp-email"></i>
                                <span>{{getCorreoNegocio()}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header-top-right float-end">
                        <ul>
                            <li>
                                <a href="{{route('perfil')}}">
                                    {{__('Account')}}
                                    <span><i class="sp-gear"></i></span>
                                </a>
                                <ul class="submenu">
                                    <li class="py-1">
                                        <a href="{{route('perfil')}}">
                                            {{__('My Account')}}
                                        </a>
                                    </li>
                                    @auth
                                        @can('Panel administrativo')
                                        <li class="py-1">
                                            <a href="{{route('admin.home')}}">
                                                {{__('Panel admin')}}
                                            </a>
                                        </li>
                                        @endcan
                                    @endauth
{{--                                    <li class="py-1">--}}
{{--                                        <a href="{{route('home')}}">--}}
{{--                                            {{__('Wishlist')}}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="py-1">--}}
{{--                                        <a href="{{route('carro.pagar')}}">--}}
{{--                                            {{__('Checkout')}}--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
                                    @auth

                                        <li class="py-1">

                                            <a class="btn btn-outline-warning btn-sm" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    @else
                                    <li class="py-1">
                                        <a href="{{route('login')}}">
                                            {{__('Login')}}
                                        </a>
                                    </li>
                                    @endauth
                                </ul>
                            </li>
                        </ul>
                        <div class="header-search">
                            <form action="#">
                                <input type="text" placeholder="{{__('Search')}}..." />
                                <button type="submit"><i class="sp-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header-Top End -->
    <!-- Main-Header Start -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-6">
                    <div class="logo">
                        <a href="{{route('index')}}"><img src="{{asset('ecommerce/img/logo.png')}}" alt="" /></a>
                    </div>
                </div>
                <div class="col-lg-8 d-none d-lg-block">
                    <div class="main-menu float-end">
                        <nav>
                            <ul>
                                <li>
                                    <a href="{{route('home')}}">
                                        {{__('Home')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('tienda')}}">
                                        {{__('Shop')}}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('categorias')}}">
                                        {{__('Categories')}}
                                    </a>
                                    <ul class="submenu">
                                        <li class="submenu-title">
                                            <a href="{{route('categorias')}}">
                                                {{__('All Categories')}}
                                            </a>
                                        </li>
                                        @foreach(\App\Models\ItemCategoria::all() as $cat)
                                            <li>
                                                <a href="{{route('tienda')."?categoria=".$cat->id}}">
                                                    {{$cat->nombre}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li>
                                    <a href="{{route('marcas')}}">
                                        {{__("Brands")}}
                                    </a>
                                    <ul class="submenu">
                                        <li class="submenu-title">
                                            <a href="{{route('marcas')}}">
                                                {{__("All Brands")}}
                                            </a>
                                        </li>

                                        @foreach(\App\Models\Marca::all() as $marca)
                                            <li>
                                                <a href="{{route('tienda')."?marca=".$marca->id}}">
                                                    {{$marca->nombre}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('contact')}}">
                                        {{__('contact')}}
                                    </a>
                                </li>



                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2 col-6">
                    @include('ecommerce.layout.partials.carrito_navbar')
                </div>
            </div>
        </div>
    </div>
    <!-- Main-Header End -->
    <!-- Mobile-menu start -->
    <div class="mobile-menu-area d-block d-md-none">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">

                            <ul>
                                <li>
                                    <a href="{{route('home')}}">
                                        {{__('Home')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('tienda')}}">
                                        {{__('Shop')}}
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('categorias')}}">
                                        {{__('Categories')}}
                                    </a>
                                    <ul class="submenu">
                                        <li class="submenu-title">
                                            <a href="{{route('categorias')}}">
                                                {{__('All Categories')}}
                                            </a>
                                        </li>
                                        @foreach(\App\Models\ItemCategoria::all() as $cat)
                                            <li>
                                                <a href="{{route('tienda')."?categoria=".$cat->id}}">
                                                    {{$cat->nombre}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li>
                                    <a href="{{route('marcas')}}">
                                        {{__("Brands")}}
                                    </a>
                                    <ul class="submenu">
                                        <li class="submenu-title">
                                            <a href="{{route('marcas')}}">
                                                {{__("All Brands")}}
                                            </a>
                                        </li>

                                        @foreach(\App\Models\Marca::all() as $marca)
                                            <li>
                                                <a href="{{route('tienda')."?marca=".$marca->id}}">
                                                    {{$marca->nombre}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{route('contact')}}">
                                        {{__('contact')}}
                                    </a>
                                </li>

                                @auth

                                    <li>
                                        <a class="btn btn-outline-warning btn-sm" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{route('login')}}">
                                            {{__('Login')}}
                                        </a>
                                    </li>
                                @endauth

{{--                                <li>--}}
{{--                                    <a href="{{route('about')}}">--}}
{{--                                        {{__('about')}}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile-menu end -->
</header>
<!-- HEADER-AREA END -->
