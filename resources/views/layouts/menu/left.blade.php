<!-- Left Side Of Navbar -->
<ul class="navbar-nav mr-auto">
    @auth('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">{{ __('Categories') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('products.index') }}">{{ __('Products') }}</a>
    </li>

    {{--Employees menu--}}
    <li class="nav-item dropdown">

        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false" v-pre>
            {{ __('Employees') }} <span class="caret"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="nav-link" href="{{ route('admins.index') }}">{{ __('Admins') }}</a>
            <a class="nav-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>

        </div>
    </li>
    @endauth
</ul>
