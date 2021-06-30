<header class="header shop">

    <div style="margin-top:-10px;" class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                    <!-- Logo -->
                    <div>
                        @php
                        $settings=DB::table('settings')->get();
                        @endphp
                        <a href="{{route('home')}}"><img id="logoprincipal"
                                src="@foreach($settings as $data) {{$data->logo}} @endforeach" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                    <!-- Search Form -->
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                        <!-- Search Form -->
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Search Form -->
                    </div>
                    <!--/ End Search Form -->
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option>Todo</option>
                                @foreach(Helper::getAllCategory() as $cat)
                                <option>{{$cat->title}}</option>
                                @endforeach
                            </select>
                            <form method="POST" action="{{route('product.search')}}">
                                @csrf
                                <input name="search" placeholder="Buscar Produtos Aquí....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        <!-- Search Form -->
                        <div class="sinlge-bar shopping">
                            <p hidden>
                                @php
                                $total_prod=0;
                                $total_amount=0;
                                @endphp
                                @if(session('wishlist'))
                                @foreach(session('wishlist') as $wishlist_items)
                                @php
                                $total_prod+=$wishlist_items['quantity'];
                                $total_amount+=$wishlist_items['amount'];
                                @endphp
                                @endforeach
                                @endif
                            </p>
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"></i> <span
                                    class="total-count">{{Helper::wishlistCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{count(Helper::getAllProductFromWishlist())}} Items</span>
                                    <a href="{{route('wishlist')}}">Ver Listado</a>
                                </div>
                                <ul class="shopping-list">
                                    {{Helper::getAllProductFromCart()}}
                                    @foreach(Helper::getAllProductFromWishlist() as $data)
                                    @php
                                    $photo=explode(',',$data->product['photo']);
                                    @endphp
                                    <li>
                                        <a href="{{route('wishlist-delete',$data->id)}}" class="remove"
                                            title="Remove this item"><i class="fa fa-remove"></i></a>
                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                target="_blank">{{$data->product['title']}}</a></h4>
                                        <p class="quantity">{{$data->quantity}} x - <span
                                                class="amount">${{number_format($data->price,2)}}</span></p>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span
                                            class="total-amount">${{number_format(Helper::totalWishlistPrice(),2)}}</span>
                                    </div>
                                    <a href="{{route('cart')}}" class="btn animate">Carrito</a>
                                </div>
                            </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="sinlge-bar">
                            <a href="{{route('wishlist')}}" class="single-icon"><i class="fa fa-heart-o"
                                    aria-hidden="true"></i></a>
                        </div>
                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span
                                    class="total-count">{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                            <div class="shopping-item">
                                <div class="dropdown-cart-header">
                                    <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                    <a href="{{route('cart')}}">Ver carrito</a>
                                </div>
                                <ul class="shopping-list">
                                    <p hidden>
                                        {{Helper::getAllProductFromCart()}}
                                        @foreach(Helper::getAllProductFromCart() as $data)
                                        @php
                                        $photo=explode(',',$data->product['photo']);
                                        @endphp
                                    </p>
                                    <li>
                                        <a href="{{route('cart-delete',$data->id)}}" class="remove"
                                            title="Remove this item"><i class="fa fa-remove"></i></a>
                                        <a class="cart-img" href="#"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></a>
                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}"
                                                target="_blank">{{$data->product['title']}}</a></h4>
                                        <p class="quantity">{{$data->quantity}} x - <span
                                                class="amount">${{number_format($data->price,2)}}</span></p>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="bottom">
                                    <div class="total">
                                        <span>Total</span>
                                        <span class="total-amount">${{number_format(Helper::totalCartPrice(),2)}}</span>
                                    </div>
                                    <a href="{{route('checkout')}}" class="btn animate">Comprar</a>
                                </div>
                            </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <!-- Main Menu -->
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">
                                    <div class="nav-inner">
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a
                                                    href="{{route('home')}}">Inicio</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a
                                                    href="{{route('about-us')}}">Nosotros</a></li>
                                            <li
                                                class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif">
                                                <a href="{{route('product-grids')}}">Productos</a><span
                                                    class="new">Nuevo</span></li>
                                            {{Helper::getHeaderCategory()}}
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a
                                                    href="{{route('blog')}}">Blog</a></li>

                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a
                                                    href="{{route('contact')}}">Contacto</a></li>

                                            @if (Route::has('login'))
                                            @auth
                                            <li class=""><a
                                                    href="{{route('admin')}}">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                                            </li>
                                            @else
                                            <li class="{{Request::path()=='user/login' ? 'active' : ''}}"><a
                                                    href="{{route('login.form')}}">Iniciar Sesión</a></li>
                                            <li class="{{Request::path()=='user/register' ? 'active' : ''}}"><a
                                                    href="{{route('register.form')}}">Registrarse</a></li>
                                            @endauth
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <!--/ End Main Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>