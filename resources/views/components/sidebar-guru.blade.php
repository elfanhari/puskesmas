<li class="dropdown {{ Request::is('permintaan-barang*') | Request::is('pembelian-barang*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i><span>TRANSAKSI</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('permintaan-barang*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('permintaan-barang') }}">Permintaan Barang</a>
        </li>
    </ul>
</li>
