<div class="row">
    {{-- Grafik Kegiatan --}}
    <div class="col">
        <div class="box">
            <div class="box-header">
                <h2>Grafik Kegiatan</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col">
                        <div class="easyPieChart text-center" data-redraw="true" data-percent="{{ $rfk['kegiatan']['target'] }}" data-bar-color="#ff0049">
                            <div class="persen">
                                {{ $rfk['kegiatan']['target'] }}%
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <small>
                            <p>Target: {{ $rfk['kegiatan']['target'] }}%</p>
                            <p>OPD: {{ $rfk['kegiatan']['opd'] }}</p>
                        </small>
                    </div>
                    <div class="col">
                        <div class="easyPieChart text-center" data-redraw="true" data-percent="{{ $rfk['kegiatan']['realisasi'] }}" data-bar-color="#FFA500">
                            <div class="persen">
                                {{ $rfk['kegiatan']['realisasi'] }}%
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <small>
                            <p>Realisasi: {{ $rfk['kegiatan']['realisasi'] }}%</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Grafik Keuangan --}}
    <div class="col">
        <div class="box">
            <div class="box-header">
                <h2>Grafik Keuangan</h2>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col">
                        <div class="easyPieChart text-center" data-redraw="true" data-percent="{{ $rfk['keuangan']['persentase_target'] }}" data-bar-color="#ff0049">
                            <div class="persen">
                                {{ $rfk['keuangan']['persentase_target'] }}%
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <small>
                            <p>Target: Rp.{{ number_format($rfk['keuangan']['nominal_target'],2) }}</p>
                        </small>
                    </div>
                    <div class="col">
                        <div class="easyPieChart text-center" data-redraw="true" data-percent="{{ $rfk['keuangan']['persentase_realisasi'] }}" data-bar-color="#FFA500">
                            <div class="persen">
                                {{ $rfk['keuangan']['persentase_realisasi'] }}%
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <small>
                            <p>Realisasi: Rp.{{ number_format($rfk['keuangan']['nominal_realisasi'],2) }}</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
