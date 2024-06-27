<ul class="navbar-nav bg-custom-dark-2 sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center"
        href="{{ in_array(auth()->user()->role, ['1', '2']) ? '/' : '/peminjamanUmum' }}">
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

    @can('umum')
        <li class="nav-item {{ Request::is('daftar-barang') ? 'active' : '' }}">
            <a href="/daftar-barang" class="nav-link">
                <i class="fas fa-fw fa-users"></i>
                <span>Daftar Barang</span>
            </a>
        </li>
        <li class="nav-item {{ Request::is('peminjamanUmum') ? 'active' : '' }}">
            <a href="/peminjamanUmum" class="nav-link">
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
    @endcan

    @can('admin')
        <li class="nav-item {{ Request::is(['kategori-barang', 'merk-barang', 'barang']) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#barang" aria-expanded="true"
                aria-controls="barang">
                <i class="fas fa-archive"></i>
                <span>{{ Request::is('barang') ? 'Data Barang' : (Request::is('kategori-barang') ? 'Kategori Barang' : (Request::is('merk-barang') ? 'Merk' : 'Barang')) }}</span>
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
                    <a class="collapse-item {{ Request::is('merk-barang') ? 'active' : '' }}"
                        href="{{ route('merk-barang.index') }}">
                        <span>Merk</span>
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ Request::is('berita') || Request::is('kategori-berita') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#berita" aria-expanded="true"
                aria-controls="berita">
                <i class="far fa-calendar-plus"></i>
                <span>{{ Request::is('berita') ? 'Data Berita' : (Request::is('kategori-berita') ? 'Kategori Berita' : 'Berita') }}</span>
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
            class="nav-item {{ Request::is(['barangM', 'peminjaman', 'barang-keluar', 'pemasok', 'pengembalian', 'request-peminjaman']) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pengelolaanData"
                aria-expanded="true" aria-controls="pengelolaanData">
                <i class="fas fa-fw fa-calendar-week"></i>
                <span>{{ Request::is('barangM') ? 'Barang Masuk' : (Request::is('peminjaman') ? 'Peminjaman' : (Request::is('barang-keluar') ? 'Barang Keluar BHP' : (Request::is('pemasok') ? 'Pemasok' : (Request::is('pengembalian') ? 'Pengembalian' : (Request::is('request-peminjaman') ? 'Request Peminjaman' : 'Manajemen Barang'))))) }}
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

                    <a class="collapse-item {{ Request::is('request-peminjaman') ? 'active' : '' }}"
                        href="/request-peminjaman">
                        Request Peminjaman
                    </a>
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
        <li class="nav-item {{ Request::is(['prodi', 'jabatan']) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#others"
                aria-expanded="true" aria-controls="others">
                <i class="fas fa-network-wired"></i>
                <span>{{ Request::is('prodi') ? 'Prodi' : (Request::is('jabatan') ? 'Jabatan' : 'Others') }}</span>
            </a>
            <div id="others" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('jabatan') ? 'active' : '' }}" href="/jabatan">
                        <i class="fas fa-archive"></i>
                        <span>Jabatan</span>
                    </a>
                    <a class="collapse-item {{ Request::is('prodi') ? 'active' : '' }}"
                        href="{{ route('prodi.index') }}">
                        <i class="fas fa-user-graduate"></i>
                        <span>Prodi</span>
                    </a>
                </div>
            </div>
        </li>
    @endcan
    @role(['1', '2'])
        <li
            class="nav-item {{ Request::is(['laporan-barang', 'laporan-barang-masuk', 'laporan-barang-keluar', 'laporan-peminjaman', 'laporan-stok']) ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#laporan"
                aria-expanded="true" aria-controls="laporan">
                <i class="fas fa-fw fa-solid fa-list"></i>
                <span>{{ Request::is('laporan-barang')
                    ? 'Laporan Barang'
                    : (Request::is('laporan-barang-keluar')
                        ? 'Transaksi Keluar'
                        : (Request::is('laporan-barang-masuk')
                            ? 'Transaksi Masuk'
                            : (Request::is('laporan-peminjaman')
                                ? 'Laporan Peminjaman'
                                : (Request::is('laporan-stok')
                                    ? 'Laporan Stok Barang'
                                    : 'Laporan')))) }}</span>
            </a>
            <div id="laporan" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ Request::is('laporan-barang') ? 'active' : '' }}" href="/laporan-barang">
                        <i class="fas fa-archive"></i>
                        <span>Barang</span>
                    </a>
                    <a class="collapse-item {{ Request::is('laporan-barang-masuk') ? 'active' : '' }}"
                        href="/laporan-barang-masuk">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Transaksi Masuk</span>
                    </a>
                    <a class="collapse-item {{ Request::is('laporan-barang-keluar') ? 'active' : '' }}"
                        href="/laporan-barang-keluar">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Transaksi Keluar</span>
                    </a>
                    <a class="collapse-item {{ Request::is('laporan-peminjaman') ? 'active' : '' }}"
                        href="/laporan-peminjaman">
                        <i class="fas fa-hand-holding"></i>
                        <span>Peminjaman</span>
                    </a>
                    <a class="collapse-item {{ Request::is('laporan-stok') ? 'active' : '' }}" href="/laporan-stok">
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
        <a class="btn btn-success btn-sm" target="blank" href="https://www.instagram.com/pbltrpl2b_kel4/">Chat
            Owner</a>
    </div>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
