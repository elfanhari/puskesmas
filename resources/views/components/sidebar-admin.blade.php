<li class="{{ Request::is('puskesmas*') ? 'active' : '' }}"><a class="nav-link" href="/puskesmas"><i class="fas fa-building"></i> <span>Data Puskesmas</span></a></li>

<li class="dropdown {{ Request::is('user*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>DATA PENGGUNA</span></a>
    @php
        $roles = [
            'admin' => 'Data Admin',
            'petugas' => 'Data Petugas',
            'dokter' => 'Data Dokter',
            'kepala' => 'Data Kepala Puskesmas',
        ];
    @endphp

    <ul class="dropdown-menu">
        @foreach ($roles as $role => $label)
            <li class="{{ Request::is("user/$role*") ? 'active' : '' }}">
                <a class="nav-link" href="{{ url("user/$role") }}">{{ $label }}</a>
            </li>
        @endforeach
    </ul>
</li>

<li class="dropdown {{ Request::is('poli*') | Request::is('obat*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i><span>MASTER</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('poli*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('poli') }}">Data Poli</a>
        </li>
        <li class="{{ Request::is('obat*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('obat') }}">Data Obat </a>
        </li>
    </ul>
</li>

<li class="{{ Request::is('pasien*') ? 'active' : '' }}">
    <a class="nav-link" href="/pasien">
        <i class="fas fa-address-card"></i> <span>Data Pasien</span>
    </a>
</li>

<li class="{{ Request::is('pendaftaran*') ? 'active' : '' }}">
    <a class="nav-link" href="/pendaftaran">
        <i class="fas fa-clipboard-list"></i> <span>Data Pendaftaran</span>
    </a>
</li>

{{-- <li class="{{ Request::is('rekam-medis*') ? 'active' : '' }}">
    <a class="nav-link" href="/rekam-medis">
        <i class="fas fa-notes-medical"></i> <span>Data Rekam Medis</span>
    </a>
</li>

<li class="{{ Request::is('pengambilan-obat*') ? 'active' : '' }}">
    <a class="nav-link" href="/pengambilan-obat">
        <i class="fas fa-pills"></i> <span>Pengambilan Obat</span>
    </a>
</li> --}}


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
