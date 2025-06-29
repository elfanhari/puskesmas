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

<li class="{{ Request::is('rekam-medis*') ? 'active' : '' }}">
    <a class="nav-link" href="/rekam-medis">
        <i class="fas fa-notes-medical"></i> <span>Data Rekam Medis</span>
    </a>
</li>

<li class="{{ Request::is('pengambilan-obat*') ? 'active' : '' }}">
    <a class="nav-link" href="/pengambilan-obat">
        <i class="fas fa-pills"></i> <span>Pengambilan Obat</span>
    </a>
</li>
