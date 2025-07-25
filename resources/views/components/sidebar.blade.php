<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">{{ auth()->user()->role_formatted }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#"></a>
        </div>
        <ul class="sidebar-menu">

            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}"><a class="nav-link" href="/dashboard"><i class="fas fa-home"></i> <span>DASHBOARD</span></a></li>

            @can('admin')
                <x-sidebar-admin />
            @endcan

            @can('petugas')
                <x-sidebar-petugas />
            @endcan

            @can('dokter')
                <x-sidebar-dokter />
            @endcan

            @can('kepala')
                <x-sidebar-kepala />
            @endcan

            <li class="{{ Request::is('profile*') ? 'active' : '' }}"><a class="nav-link" href="/profile/show"><i class="fas fa-user"></i> <span>Profile</span></a></li>

        </ul>

    </aside>
</div>
