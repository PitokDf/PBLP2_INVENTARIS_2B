<ul class="navbar-nav bg-custom-dark-2 sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon "><img style="width:35px" src="{{ asset('asset/baru3.png') }}"></div>

        <div class="sidebar-brand-text mx-3">IT Ventory</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (in_array(auth()->user()->role, ['1', '2']))
        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>
    @if (auth()->user()->role == 1)
        <li class="nav-item {{ Request::is('barang') || Request::is('kategori-barang') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barang"
                aria-expanded="true" aria-controls="barang">
                <i class="fas fa-archive"></i>
                <span>Barang</span>
            </a>
            <div id="barang" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('barang') ? 'active' : '' }}"
                        href="{{ route('barang.index') }}">
                        <span>Data Barang</span>
                    </a>
                    <a class="collapse-item {{ Request::is('kategori-barang') ? 'active' : '' }}"
                        href="{{ route('kategori-barang.index') }}">
                        <span>Kategori Barang</span>
                    </a>
                </div>
            </div>
        </li>
    @endif

    @if (auth()->user()->role == 1)
        <li class="nav-item {{ Request::is('berita') || Request::is('kategori-berita') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#berita"
                aria-expanded="true" aria-controls="berita">
                <i class="far fa-calendar-plus"></i>
                <span>Berita</span>
            </a>
            <div id="berita" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @if (Route::has('berita.index'))
                        <a class="collapse-item {{ Request::is('berita') ? 'active' : '' }}"
                            href="{{ route('berita.index') }}">
                            <span>Data Berita</span>
                        </a>
                    @endif
                    <a class="collapse-item {{ Request::is('kategori-berita') ? 'active' : '' }}"
                        href="{{ route('kategori-berita.index') }}">
                        <span>Kategori Berita</span>
                    </a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item {{ Request::is('dosen') ? 'active' : '' }}">
            <a href="{{ route('dosen.index') }}" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Dosen</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('mahasiswa') ? 'active' : '' }}">
            <a href="{{ route('mahasiswa.index') }}" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Mahasiswa</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('user') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
        </li>
    @endif

    @if (in_array(auth()->user()->role, ['1']))
        <li class="nav-item {{ Request::is('') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengelolaanData"
                aria-expanded="true" aria-controls="pengelolaanData">
                <i class="fas fa-fw fa-calendar-week"></i>
                <span>Manajemen Barang</span>
            </a>
            <div id="pengelolaanData" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('pengelolaan/barang-masuk') ? 'active' : '' }}"
                        href="{{--  --}}">
                        <span>Barang Masuk</span>
                    </a>
                    <a class="collapse-item {{ Request::is('pengelolaan/barang-keluar') ? 'active' : '' }}"
                        href="{{--  --}}">
                        <span>Barang Keluar BHP</span>
                    </a>
                    <a class="collapse-item {{ Request::is('pengelolaan/pengembalian') ? 'active' : '' }}"
                        href="{{--  --}}">
                        <span>Barang Pengembalian</span>
                    </a>

                    <a class="collapse-item {{ Request::is('pengelolaan/pinjaman') ? 'active' : '' }}"
                        href="{{--  --}}">
                        Barang Pinjaman
                    </a>
                </div>
            </div>
        </li>
    @endif
    @if (in_array(auth()->user()->role, ['3', '4', '5']))
        <li class="nav-item {{ Request::is('pinjaman') ? 'active' : '' }}">
            <a href="{{--  --}}" class="nav-link">
                <i class="fas fa-fw fa-hand-holding"></i>
                <span>Barang Pinjaman</span>
            </a>
        </li>
    @endif
    @if (auth()->user()->role == 1 || auth()->user()->role == 2)
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan"
                aria-expanded="true" aria-controls="laporan">
                <i class="fas fa-fw fa-solid fa-list"></i>
                <span>Laporan</span>
            </a>
            <div id="laporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('pengelolaan/data-barang') ? 'active' : '' }}"
                        href="{{--  --}}">
                        <i class="fas fa-archive"></i>
                        <span>Data Barang</span>
                    </a>
                    <a class="collapse-item {{ Route::is('pengelolaan/data-barang') ? 'active' : '' }}"
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
    @endif
    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        {{-- <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="..."> --}}
        <p class="text-center mb-2"><strong>Copyright &copy; PBL P2 TRPL2B {{ date('Y') }}</strong></p>
        <a class="btn btn-success btn-sm" target="blank" href="https://www.instagram.com/pitok_df">Chat Owner</a>
    </div>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
