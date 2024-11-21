<nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('home')}}">Home</a>
                </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        @if(auth()->check())
                            <a class="nav-link active" href="{{route('logout')}}">
                                Logout
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </a>
                        @else
                            <a class="nav-link active" href="{{route('login')}}">
                                <i class="fa-solid fa-user"></i>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a id="basket" class="nav-link" href="{{route('cartShow')}}">
                            <i class="fa-solid fa-basket-shopping item-icon"></i>
                            <span id="cart-qty" class="qty {{$cart->count == 0 ? 'd-none' : ''}}" >{{$cart->count}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
