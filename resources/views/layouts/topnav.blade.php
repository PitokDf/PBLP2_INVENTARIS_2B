<?php $data = App\Models\Peminjaman::with(['barang', 'user', 'user.dosen', 'user.mahasiswa'])
    ->where('status', '=', false)
    ->get(); ?>
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        @role('1')
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <!-- Counter - Alerts -->
                    {!! $data->count() != 0 ? '<span class="badge badge-danger badge-counter">' . $data->count() . '</span>' : '' !!}
                </a>
                <!-- Dropdown - Alerts -->
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Request Peminjaman
                    </h6>
                    @if ($data->count() < 5)
                        @for ($i = 0; $i < $data->count(); $i++)
                            <a class="dropdown-item d-flex align-items-center" href="/request-peminjaman">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $data[$i]->tgl_peminjaman }}</div>
                                    <span class="font-weight-bold">{{ $data[$i]->keterangan }}</span>
                                </div>
                            </a>
                        @endfor
                    @else
                        @for ($i = 0; $i < 5; $i++)
                            <a class="dropdown-item d-flex align-items-center" href="/request-peminjaman">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">{{ $data[$i]->tgl_peminjaman }}</div>
                                    <span class="font-weight-bold">{{ $data[$i]->keterangan }}</span>
                                </div>
                            </a>
                        @endfor
                    @endif
                    <a class="dropdown-item text-center small text-gray-500" href="/request-peminjaman">Show All
                        Alerts</a>
                </div>
            </li>
        @endrole
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span
                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->mahasiswa_id ? auth()->user()->mahasiswa->nama : (auth()->user()->dosen_id ? auth()->user()->dosen->name : Auth::user()->username) }}</span>
                <img class="img-profile rounded-circle"
                    src=" {{ auth()->user()->avatar
                        ? '/storage/avatar/' . auth()->user()->avatar
                        : 'https://ui-avatars.com/api/?name=' .
                            (auth()->user()->mahasiswa_id
                                ? auth()->user()->mahasiswa->nama
                                : (auth()->user()->dosen_id
                                    ? auth()->user()->dosen->name
                                    : Auth::user()->username)) .
                            '&background=4e73df&color=ffffff&size=100' }} ">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                @if (auth()->user()->role == '1')
                    <a class="dropdown-item" href="#" id="activity-log">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Activity Log
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
    @if (auth()->user()->role == '1')
        {{-- modal activity log --}}
        <!-- Modal -->
        <div class="modal fade" id="modalActivity" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="" id="modalTitleId">
                            Activity Log user
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="activity-content">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</nav>
