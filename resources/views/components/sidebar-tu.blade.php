<li class="dropdown {{ Request::is('supplier*') | Request::is('barang*') | Request::is('kategori-barang*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-box"></i><span>BARANG</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('supplier*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('supplier') }}">Data Supplier</a>
        </li>
        <li class="{{ Request::is('kategori-barang*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('kategori-barang') }}">Data Kategori Barang</a>
        </li>
        <li class="{{ Request::is('barang*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('barang') }}">Data Barang</a>
        </li>
    </ul>
</li>

<li class="dropdown {{ Request::is('permintaan-barang*') | Request::is('pembelian-barang*') ? 'active' : '' }}">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-credit-card"></i><span>TRANSAKSI</span></a>
    <ul class="dropdown-menu">
        <li class="{{ Request::is('permintaan-barang*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('permintaan-barang') }}">Permintaan Barang</a>
        </li>
    </ul>
</li>
