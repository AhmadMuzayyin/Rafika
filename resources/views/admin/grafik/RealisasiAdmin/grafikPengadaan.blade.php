<div class="row">
    <div class="col">
        <div class="box">
            <div class="box-header">
                <h2>Jenis Pengadaan [{{ $jenisPG->nama_pengadaan }}]</h2>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline dropdown">
                        <a class="nav-link" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons md-18"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-scale pull-right">
                            @foreach ($pengadaan as $pg)
                                <a class="dropdown-item"
                                    href="{{ url('/admin/realisasi?bulan=') . (request()->get('bulan') ?? 1) . '&pengadaan=' . $pg->id . '&dana=' . (request()->get('dana') ?? 1) }}">
                                    {{ $pg->nama_pengadaan }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
            <div class="box-body">
                <div class="row">
                    {{-- Column 1 --}}
                    <div class="col">
                        <p>Kegiatan</p>
                        <div class="row">
                            {{-- Colum Content --}}
                            <div class="col">
                                <div class="easyPieChart text-center" data-redraw="true"
                                    data-percent="{{ $pgn['kegiatan']['target'] }}" data-bar-color="#ff0049">
                                    <div class="persen">
                                        {{ $pgn['kegiatan']['target'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Target: {{ $pgn['kegiatan']['target'] }}%</p>
                                    <p>OPD: {{ $pgn['kegiatan']['opd'] }}</p>
                                </small>
                            </div>
                            <div class="col">
                                <div class="easyPieChart text-center" data-redraw="true"
                                    data-percent="{{ $pgn['kegiatan']['realisasi'] }}" data-bar-color="#FFA500">
                                    <div class="persen">
                                        {{ $pgn['kegiatan']['realisasi'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Realisasi: {{ $pgn['kegiatan']['realisasi'] }}%</p>
                                </small>
                            </div>
                        </div>
                    </div>
                    {{-- End Column 1 --}}

                    {{-- Column 2 --}}
                    <div class="col">
                        <p>Keuangan</p>
                        <div class="row">
                            {{-- Colum Content --}}
                            <div class="col">
                                <div class="easyPieChart text-center" data-redraw="true"
                                    data-percent="{{ $pgn['kegiatan']['target'] }}" data-bar-color="#ff0049">
                                    <div class="persen">
                                        {{ $pgn['kegiatan']['target'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Target: {{ $pgn['kegiatan']['target'] }}%</p>
                                    <p>OPD: {{ $pgn['kegiatan']['opd'] }}</p>
                                </small>
                            </div>
                            <div class="col">
                                <div class="easyPieChart text-center" data-redraw="true"
                                    data-percent="{{ $pgn['kegiatan']['realisasi'] }}" data-bar-color="#FFA500">
                                    <div class="persen">
                                        {{ $pgn['kegiatan']['realisasi'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Realisasi: {{ $pgn['kegiatan']['realisasi'] }}%</p>
                                </small>
                            </div>
                        </div>
                    </div>
                    {{-- End Column 2 --}}
                </div>
            </div>
        </div>
    </div>
</div>
