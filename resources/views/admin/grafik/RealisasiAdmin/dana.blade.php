<div class="row">
    <div class="col">
        <div class="box">
            <div class="box-header">
                <h2>Sumber Dana [{{ $jenisDANA->nama_sumber_dana }}]</h2>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline dropdown">
                        <a class="nav-link" data-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons md-18"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-scale pull-right">
                            @foreach ($dana as $dn)
                                <a class="dropdown-item"
                                    href="{{ url('/admin/realisasi?bulan=') . (request()->get('bulan') ?? 1) . '&pengadaan=' . (request()->get('pengadaan') ?? 1) . '&dana=' . $dn->id }}">
                                    {{ $dn->nama_sumber_dana }}
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
                                    data-percent="{{ $sumber['kegiatan']['target'] }}" data-bar-color="#ff0049">
                                    <div class="persen">
                                        {{ $sumber['kegiatan']['target'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Target: {{ $sumber['kegiatan']['target'] }}%</p>
                                    <p>OPD: {{ $sumber['kegiatan']['opd'] }}</p>
                                </small>
                            </div>
                            <div class="col">
                                <div class="easyPieChart text-center" data-redraw="true"
                                    data-percent="{{ $sumber['kegiatan']['realisasi'] }}" data-bar-color="#FFA500">
                                    <div class="persen">
                                        {{ $sumber['kegiatan']['realisasi'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Realisasi: {{ $sumber['kegiatan']['realisasi'] }}%</p>
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
                                    data-percent="{{ $sumber['kegiatan']['target'] }}" data-bar-color="#ff0049">
                                    <div class="persen">
                                        {{ $sumber['kegiatan']['target'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Target: {{ $sumber['kegiatan']['target'] }}%</p>
                                    <p>OPD: {{ $sumber['kegiatan']['opd'] }}</p>
                                </small>
                            </div>
                            <div class="col">
                                <div class="easyPieChart text-center" data-redraw="true"
                                    data-percent="{{ $sumber['kegiatan']['realisasi'] }}" data-bar-color="#FFA500">
                                    <div class="persen">
                                        {{ $sumber['kegiatan']['realisasi'] }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <small>
                                    <p>Realisasi: {{ $sumber['kegiatan']['realisasi'] }}%</p>
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
