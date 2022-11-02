@php
    $route = Route::currentRouteName();
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="{{ asset('admin/dist/img/logo.png') }}" alt="Admin DVD Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin DVD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            @php
                if (!empty(adminInfo('avatar_path'))) {
                    $avatarUrl = \App\Helpers\GoogleDriveHelpers::getImage(adminInfo('avatar_path'));
                }
                if (empty($avatarUrl)) {
                    if (adminInfo('gender') == \App\Config\AppConstants::GENDER_FEMALE) {
                        $avatarUrl = asset('admin/main/image/avatar_default_2.png');
                    } else {
                        $avatarUrl = asset('admin/main/image/avatar_default_1.png');
                    }
                }
            @endphp
            <div class="image">
                <img src="{{ $avatarUrl }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('admin.profile.index') }}" class="d-block">{{ adminInfo('name') }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- Home DVD -->
                <li class="nav-item">
                    <a class="nav-link @if($route == 'admin.home') active @endif" href="{{ route('admin.home') }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>{{ __('Home') }}</p>
                    </a>
                </li>

                <!-- Menu Finance DVD -->
                @include('Finance::admin.layouts.menu', ['route' => $route])

                @include('Product::admin.layouts.menu', ['route' => $route])

                <!-- Menu Admin DVD -->
                @include('admin.layouts.menu', ['route' => $route])

                <li class="nav-header">MY ACCOUNT</li>
                <li class="nav-item">
                    <a class="nav-link @if($route == 'admin.profile.index') active @endif"
                        href="{{ route('admin.profile.index') }}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>{{ __('My Account') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('admin.logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout_form_master').submit();">
                        <i class="nav-icon fas fa-sign-in-alt"></i>
                        <p>{{ __('Logout') }}</p>
                    </a>
                    <form id="logout_form_master" action="{{ route('admin.logout') }}"
                          method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
