

@include('ecommerce.partials.banner_servicios')

<!-- FOOTER-AREA START -->
<footer class="footer-area">
    <div class="footer-top">
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-footer footer-logo">
                            <img src="{{asset('ecommerce/img/logo.png')}}" alt="" />
                            <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4">
                        <div class="single-footer footer-contact">
                            <h2>contact us</h2>
                            <ul>
                                <li>
                                    <i class="sp-phone"></i>
                                    <span>
                                        {{getPbx()}}
                                    </span>
                                </li>
                                <li>
                                    <i class="sp-email"></i>
                                    <span>
                                        {{getCorreoNegocio()}}
                                    </span>
                                </li>
                                <li>
                                    <i class="sp-map-marker"></i>
                                    <span>
                                        {{getDireccionNegocio()}}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="single-footer footer-menu">
                            <h2>company</h2>
                            <ul>
                                <li>
                                    <a href="{{route('login')}}">
                                        {{__('Log in')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('login')}}">
                                        {{__('Regester')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('tienda')}}">
                                        {{__('Shop')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('marcas')}}">
                                        {{__('Brands')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
{{--                    <div class="col-lg-3 col-md-4">--}}
{{--                        <div class="single-footer footer-message">--}}
{{--                            <form action="#">--}}
{{--                                <h2>--}}
{{--                                    {{__('Quick contact')}}--}}
{{--                                </h2>--}}
{{--                                <div class="footer-message-box">--}}
{{--                                    <input type="text" placeholder="your email address" />--}}
{{--                                    <textarea placeholder="your messege" ></textarea>--}}
{{--                                    <input type="submit" value="submit"/>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="copyright-brief">
                        <p>Copyright &copy; <a href="https://themeforest.net/user/codecarnival/portfolio">Codecarnival</a> All right reserved</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="footer-social text-center text-md-end">
                        <a href="#"><i class="sp-facebook"></i></a>
                        <a href="#"><i class="sp-twitter"></i></a>
                        <a href="#"><i class="sp-linkedin"></i></a>
                        <a href="#"><i class="sp-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- FOOTER-AREA END -->
