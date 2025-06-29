<li class="dropdown {{ Request::is('permintaan-barang*') | Request::is('pembelian-barang*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i><span>TRANSAKSI</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('pembelian-barang*') ? 'active' : '' }}">
            <a class="nav-link" href="/pembelian-barang?status=menunggu_persetujuan">Barang Masuk</a>
        </li>
        <li class="{{ Request::is('permintaan-barang*') ? 'active' : '' }}">
            <a class="nav-link" href="/permintaan-barang?status=menunggu_persetujuan">Barang Keluar</a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('laporan*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i><span>LAPORAN</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('laporan/barang') ? 'active' : '' }}">
            <a class="nav-link" href="/laporan/barang">Barang</a>
        </li>
        <li class="{{ Request::is('laporan/barang-keluar-masuk') ? 'active' : '' }}">
            <a class="nav-link" href="/laporan/barang-keluar-masuk">Keluar Masuk Barang</a>
        </li>
        <li class="{{ Request::is('laporan/permintaan-pembelian-barang') ? 'active' : '' }}">
            <a class="nav-link" href="/laporan/permintaan-pembelian-barang">Permintaaan Pembelian</a>
        </li>

    </ul>
</li>
