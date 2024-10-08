<nav class="nav">
    <div class="container">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Company Logo">
            <h1>Watch Store</h1>
        </div>
        <div class="menu">
            <div class="cart">
                <a href="#" onclick="event.preventDefault(); document.getElementById('cart-form').submit();">
                    <img src="{{ asset('images/cart.png') }}" alt="cart">
                    @if (session('cartItemCount') && session('cartItemCount') > 0)
                        <sup class="cartCount">{{ session('cartItemCount') }}</sup>
                        <!-- Display the count if greater than 0 -->
                    @endif
                </a>
            </div>

            <form id="cart-form" action="{{ route('cart.index') }}" method="GET" style="display: none;">
                @csrf
            </form>
            @auth
                <div class="logout">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <img src="{{ asset('images/logout.png') }}" alt="logout">
                    </a>
                </div>
                <div class="username">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            @else
                <div class="login">
                    <a href="{{ route('register') }}">
                        <img src="{{ asset('images/login.png') }}" alt="login">
                    </a>
                </div>

            @endauth


            <div class="menu-dropdown">
                <img src="{{ asset('images/menu.png') }}" alt="Menu" id="menu-toggle">
                <div class="dropdown-content" id="dropdown-content">
                    <a href="/">Home</a>
                    <a href="{{ route('about') }}">about as</a>

                    @auth
                        <a href="{{ route('profile') }}">Profile</a>
                        <a href="{{ route('order.orderStatus') }}">Order Status</a>
                    @endauth


                </div>
            </div>
        </div>

    </div>

</nav>
