<ul class="navbar-nav bg-custom-dark-2 sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon "><img style="width:35px" src="{{ asset('asset/baru3.png') }}"></div>

        <div class="sidebar-brand-text mx-3">IT Ventory</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @role(['1', '2'])
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endrole
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    @role(['3', '4', '5'])
        <li class="nav-item {{ Request::is('daftar-barang') ? 'active' : '' }}">
            <a href="/daftar-barang" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Daftar Barang</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('pengembalian') ? 'active' : '' }}">
            <a href="{{ route('peminjamanUmum.index') }}" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Pengembalian</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('pinjaman') ? 'active' : '' }}">
            <a href="{{--  --}}" class="nav-link">
                <i class="fas fa-fw fa-hand-holding"></i>
                <span>Peminjaman</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('riwayat-peminjaman') ? 'active' : '' }}">
            <a href="/riwayat-peminjaman" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Riwayat Peminjaman</span>
            </a>
        </li>
    @endrole

    @role('1')
        <li class="nav-item {{ Request::is('barang') || Request::is('kategori-barang') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barang" aria-expanded="true"
                aria-controls="barang">
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
        <li class="nav-item {{ Request::is('berita') || Request::is('kategori-berita') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#berita" aria-expanded="true"
                aria-controls="berita">
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
        <li
            class="nav-item {{ Request::is(['barangM', 'peminjaman', 'barang-keluar', 'pemasok', 'pengembalian']) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengelolaanData"
                aria-expanded="true" aria-controls="pengelolaanData">
                <i class="fas fa-fw fa-calendar-week"></i>
                <span>{{ Request::is('barangM') ? 'Barang Masuk' : (Request::is('peminjaman') ? 'Peminjaman' : (Request::is('barang-keluar') ? 'Barang Keluar BHP' : (Request::is('pemasok') ? 'Pemasok' : (Request::is('pengembalian') ? 'Pengembalian' : 'Manajemen Barang')))) }}
                </span>
            </a>
            <div id="pengelolaanData" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('barangM') ? 'active' : '' }}"
                        href="{{ route('barangM.index') }}">
                        <span>Barang Masuk</span>
                    </a>
                    <a class="collapse-item {{ Request::is('barang-keluar') ? 'active' : '' }}" href="/barang-keluar">
                        <span>Barang Keluar BHP</span>
                    </a>
                    {{-- <a class="collapse-item {{ Request::is('pengembalian') ? 'active' : '' }}" href="/pengembalian">
                        <span>Pengembalian</span>
                    </a> --}}

                    <a class="collapse-item {{ Request::is('peminjaman') ? 'active' : '' }}"
                        href="{{ route('peminjaman.index') }}">
                        Peminjaman
                    </a>
                    <a class="collapse-item {{ Request::is('pemasok') ? 'active' : '' }}"
                        href="{{ route('pemasok.index') }}">
                        Pemasok
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ Request::is('prodi') || Request::is('jabatan') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#others"
                aria-expanded="true" aria-controls="others">
                <i class="fas fa-network-wired"></i>
                <span>Others</span>
            </a>
            <div id="others" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('jabatan') ? 'active' : '' }}"
                        href="{{ route('jabatan.index') }}">
                        <i class="fas fa-archive"></i>
                        <span>Jabatan</span>
                    </a>
                    <a class="collapse-item {{ Route::is('prodi') ? 'active' : '' }}" href="{{ route('prodi.index') }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>Prodi</span>
                    </a>
                </div>
            </div>
        </li>
    @endrole

    @role(['1', '2'])
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
    @endrole

    <!-- Sidebar Message -->
    <div class="sidebar-card mt-3 d-none d-lg-flex">
        {{-- <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="..."> --}}
        <p class="text-center mb-2"><strong>Copyright &copy; PBL P2 TRPL2B {{ date('Y') }}</strong></p>
        <a class="btn btn-success btn-sm" target="blank" href="https://www.instagram.com/pitok_df">Chat Owner</a>
    </div>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
