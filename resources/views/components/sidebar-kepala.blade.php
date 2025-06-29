<li class="dropdown {{ Request::is('laporan*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span>LAPORAN</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('laporan/pasien') ? 'active' : '' }}">
            <a class="nav-link" href="/laporan/pasien">Pasien</a>
        </li>
        <li class="{{ Request::is('laporan/rekam-medis') ? 'active' : '' }}">
            <a class="nav-link" href="/laporan/rekam-medis">Rekam Medis</a>
        </li>
    </ul>
</li>
