<!-- aside -->
<div id="aside" class="app-aside modal nav-dropdown">
    <!-- fluid app aside -->
    <div class="left navside dark dk" data-layout="column">
        <div class="navbar no-radius">
            <!-- brand -->
            <a class="navbar-brand">
                <div ui-include="'{{ url('assets/images/logo.svg') }}'"></div>
                <img src="{{ url('assets/images/logo.png') }}" alt="." class="hide">
                <span class="hidden-folded inline">RAFIKA</span>
            </a>
            <!-- / brand -->
        </div>
        <div class="hide-scroll" data-flex>
            <nav class="scroll nav-light">

                @if (Auth()->user()->isAdmin == 1)
                    <ul class="nav" ui-nav>

                        <li>
                            <a onclick="window.location.href = '{{ url('/admin/dashboard') }}'">
                                <span class="nav-icon">
                                    <i class="bi bi-house-fill"></i>
                                </span>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-header hidden-folded">
                            <small class="text-muted">Main</small>
                        </li>

                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-file-earmark-arrow-up"></i>
                                </span>
                                <span class="nav-text">Entry</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/users') }}'">
                                        <span class="  nav-text">OPD</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/subkegiatan') }}'">
                                        <span class="nav-text">SUB KEGIATAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/jadwal') }}'">
                                        <span class="  nav-text">SCHEDULE</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/report') }}'">
                                        <span class="  nav-text">REALISASI</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-clipboard-data"></i>
                                </span>
                                <span class="nav-text">Report</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/rekapitulasi') }}'">
                                        <span class="  nav-text">REKAPITULASI</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/realisasi') }}'">
                                        <span class="  nav-text">REALISASI ADMIN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/arsip/rfk') }}'">
                                        <span class="nav-text">ARSIP RFK</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/grafik/pengadaan') }}'">
                                        <span class="  nav-text">GRAFIK PENGADAAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/grafik/sebaran') }}'">
                                        <span class="  nav-text">GRAFIK SEBARAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/grafik/sumberDana') }}'">
                                        <span class="  nav-text">SUMBER DANA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/grafik/pelaksanaan') }}'">
                                        <span class="  nav-text">PELAKSANAAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/laporan') }}'">
                                        <span class="  nav-text">LAPORAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/grafik/ranking') }}'">
                                        <span class="  nav-text">GRAFIK RANKING</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-printer-fill"></i>
                                </span>
                                <span class="nav-text">Print</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/dau') }}'">
                                        <span class="  nav-text">DAU</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/dak') }}'">
                                        <span class="  nav-text">DAK</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/dbhc') }}'">
                                        <span class="  nav-text">DBHC</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/kontruksi') }}'">
                                        <span class="nav-text">KONTRUKSI</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/barang') }}'">
                                        <span class="  nav-text">BARANG</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/konsultansi') }}'">
                                        <span class="  nav-text">KONSULTANSI</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/lainnya') }}'">
                                        <span class="  nav-text">JASA LAINNYA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/prioritas') }}'">
                                        <span class="  nav-text">PRIORITAS</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/kendala') }}'">
                                        <span class="  nav-text">KENDALA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/arsip/cover') }}'">
                                        <span class="  nav-text">COVER</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/arsip/jadwal') }}'">
                                        <span class="  nav-text">JADWAL</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/arsip/rfk') }}'">
                                        <span class="  nav-text">RFK</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/admin/print/arsip/grafik') }}'">
                                        <span class="  nav-text">GRAFIK</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-gear-fill"></i>
                                </span>
                                <span class="nav-text">Setting</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('pak.index') }}'">
                                        <span class="  nav-text">TAHUN PAK</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('pa.index') }}'">
                                        <span class="  nav-text">PA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('backup.index') }}'">
                                        <span class="nav-text">BACKUP DATA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('activation.index') }}'">
                                        <span class="nav-text">AKTIFASI</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                @else
                    <ul class="nav" ui-nav>

                        <li>
                            <a onclick="window.location.href = '{{ url('/operator/dashboard') }}'">
                                <span class="nav-icon">
                                    <i class="bi bi-house-fill"></i>
                                </span>
                                <span class="nav-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="nav-header hidden-folded">
                            <small class="text-muted">Main</small>
                        </li>

                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-file-earmark-arrow-up"></i>
                                </span>
                                <span class="nav-text">Entry</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/subkegiatan') }}'">
                                        <span class="nav-text">SUB KEGIATAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/jadwal') }}'">
                                        <span class="  nav-text">SCHEDULE</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/realisasi') }}'">
                                        <span class="  nav-text">REALISASI</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-clipboard-data"></i>
                                </span>
                                <span class="nav-text">Report</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/rekapitulasi') }}'">
                                        <span class="  nav-text">REKAPITULASI</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/arsip/rfk') }}'">
                                        <span class="nav-text">ARSIP RFK</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/grafik/pengadaan') }}'">
                                        <span class="  nav-text">GRAFIK PENGADAAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/grafik/sebaran') }}'">
                                        <span class="  nav-text">GRAFIK SEBARAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/grafik/sumberDana') }}'">
                                        <span class="  nav-text">SUMBER DANA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/grafik/pelaksanaan') }}'">
                                        <span class="  nav-text">PELAKSANAAN</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/laporan') }}'">
                                        <span class="  nav-text">LAPORAN</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a>
                                <span class="nav-caret">
                                    <i class="bi bi-caret-down-fill"></i>
                                </span>
                                <span class="nav-icon">
                                    <i class="bi bi-printer-fill"></i>
                                </span>
                                <span class="nav-text">Print</span>
                            </a>
                            <ul class="nav-sub">
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/dau') }}'">
                                        <span class="  nav-text">DAU</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/dak') }}'">
                                        <span class="  nav-text">DAK</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/dbhc') }}'">
                                        <span class="  nav-text">DBHC</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/kontruksi') }}'">
                                        <span class="nav-text">KONTRUKSI</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/barang') }}'">
                                        <span class="  nav-text">BARANG</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/konsultansi') }}'">
                                        <span class="  nav-text">KONSULTANSI</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/lainnya') }}'">
                                        <span class="  nav-text">JASA LAINNYA</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/prioritas') }}'">
                                        <span class="  nav-text">PRIORITAS</span>
                                    </a>
                                </li>
                                <li>
                                    <a onclick="window.location.href = '{{ url('/operator/print/kendala') }}'">
                                        <span class="  nav-text">KENDALA</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                @endif
            </nav>
        </div>
    </div>
</div>
<!-- end of aside -->
