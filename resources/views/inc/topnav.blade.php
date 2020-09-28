<nav id="topnav">
    <div id="nav-left">
        <a class="nav-item nav-link" href=" {{ route('home') }} ">Home</a>
    </div>
    <div id="nav-middle">
        <input class="nav-item" type="text" placeholder="Search..">
    </div>
    <div id="nav-right">
        @guest
            <li>
                <a class="nav-item nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li>
                    <a class="nav-item nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="dropdown">
                <a class="nav-item nav-link dropdown-button" href="#" role="button">
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu invisible">
                    <a id="logout-button" class="dropdown-item" href="{{ route('logout') }}">
                        {{ __('Logout') }}
                    </a>
                    <a class="dropdown-item" href="{{ route('posts.create') }}">
                        new post
                    </a>

                    <form id="frm-logout" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </div>
</nav>


