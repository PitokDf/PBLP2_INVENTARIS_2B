<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-text mx-3">Inventaris barang</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ Request::is('**') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengelolaanData"
            aria-expanded="true" aria-controls="pengelolaanData">
            <i class="fas fa-tasks"></i>
            <span>Pengelolaan Data</span>
        </a>
        <div id="pengelolaanData" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('') ? 'active' : '' }}" href="{{ route('barang.index') }}">
                    <i class="fas fa-box-open"></i>
                    <span>Barang</span>
                </a>
                <a class="collapse-item {{ Request::is('') ? 'active' : '' }}"
                    href="{{ route('kategori-barang.index') }}">
                    <i class="fas fa-box-open"></i>
                    <span>Kategori Barang</span>
                </a>
                <?php $admin = 'admin'; ?>
                @if ($admin == 'admin')
                    <a class="collapse-item" href="blank.html">
                        <i class="far fa-calendar-plus"></i>
                        <span>Berita</span>
                    </a>
                    <a class="collapse-item {{ Request::is('kategori-berita') ? 'active' : '' }}"
                        href="{{ route('kategori-berita.index') }}">
                        <i class="fas fa-list-alt"></i>
                        <span>Kategori Berita</span>
                    </a>
                    <a class="collapse-item {{ Request::is('user') ? 'active' : '' }}" href="{{--  --}}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                    <a class="collapse-item {{ Request::is('pengelolaan/dosen') ? 'active' : '' }}"
                        href="{{ route('dosen.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Data Dosen</span>
                    </a>
                    <a class="collapse-item {{ Request::is('pengelolaan/barang-masuk') ? 'active' : '' }}"
                        href="{{--  --}}">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Barang Masuk</span>
                    </a>
                @endif
                <a class="collapse-item {{ Request::is('pengelolaan/barang-keluar') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Barang Keluar BHP</span>
                </a>
                <a class="collapse-item {{ Request::is('pengelolaan/pengembalian') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-arrow-circle-left"></i>
                    <span>Barang Pengembalian</span>
                </a>
                <a class="collapse-item {{ Request::is('pengelolaan/pinjaman') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-hand-holding"></i>
                    <span>Barang Pinjaman</span>
                </a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan" aria-expanded="true"
            aria-controls="laporan">
            <i class="fas fa-solid fa-list"></i>
            <span>Laporan</span>
        </a>
        <div id="laporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ Request::is('pengelolaan/data-barang') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-archive"></i>
                    <span>Data Barang</span>
                </a>
                <a class="collapse-item {{ Request::is('pengelolaan/data-barang') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Transaksi Barang Masuk</span>
                </a>
                <a class="collapse-item {{ Request::is('pengelolaan/barang-keluar') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Transaksi Barang Keluar</span>
                </a>
                <a class="collapse-item {{ Request::is('pengelolaan/peminjaman') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-hand-holding"></i>
                    <span>Peminjaman</span>
                </a>
                <a class="collapse-item {{ Request::is('pengelolaan/stok') ? 'active' : '' }}"
                    href="{{--  --}}">
                    <i class="fas fa-boxes"></i>
                    <span>Stok</span>
                </a>
            </div>
        </div>
    </li>
</ul>
