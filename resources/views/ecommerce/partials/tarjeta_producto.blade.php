<div class="single-product">
    <div class="product-photo">
        <a href="{{route('productos.ficha',$item->id)}}">
            <img class="primary-photo" src="{{$item->img($dimension ?? '370x400',1)}}" alt="" />
            <img class="secondary-photo" src="{{$item->img($dimension ?? '370x400')}}" alt="" />
        </a>
        <div class="pro-action">
            <a href="#" class="action-btn">
                <i class="sp-heart"></i>
                <span>
                    {{__('Wishlist')}}
                </span>
            </a>
            <a href="#" @click.prevent="agregarCarro({{$item->id}})" class="action-btn">
                <i class="sp-shopping-cart"></i>
                <span>
                    {{__('Add to cart')}}
                </span>
            </a>
        </div>
    </div>
    <div class="product-brief">
        <h2>
            <a href="{{route('productos.ficha',$item->id)}}">
                {{$item->nombre}}
            </a>
        </h2>
        <h3>
            {{dvs().$item->precio_venta}}
        </h3>
    </div>
</div>
