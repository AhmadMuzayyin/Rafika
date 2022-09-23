@extends('template.main')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [REKAPITULASI]</h1>
                        </div>
                        <div class="box-body">
                            <h3 class="text-center"></h3>
                            <p>
                            <ul>
                                <li>Jumlah Paket : {{ isset($rekap['jml_paket']) ? $rekap['jml_paket'] : '' }}</li>
                                <li>Total Anggaran : Rp.{{ isset($rekap['anggaran']) ? number_format($rekap['anggaran'], 2) : '' }}</li>
                                <li>Persentase Kegiatan:
                                    {{ isset($rekap['jml_kegiatan']) ? round(($rekap['jml_kegiatan'] / $rekap['target_kegiatan']) * 100, 2) : '' }}%
                                </li>
                                <li>Persentase Keuangan:
                                    {{ isset($rekap['jml_keuangan']) ? round(($rekap['jml_keuangan'] / $rekap['anggaran']) * 100, 2) : '' }}%
                                </li>
                            </ul>
                            </p>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">No</th>
                                            <th rowspan="3">BULAN</th>
                                            <th colspan="2" class="text-center">KEGIATAN</th>
                                            <th colspan="3" class="text-center">KEUANGAN</th>
                                            <th rowspan="3">STATUS</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">TARGET</th>
                                            <th rowspan="2">REALISASI</th>
                                        </tr>
                                        <tr>
                                            <th>TARGET</th>
                                            <th>REALISASI</th>
                                            <th>PERSENTASE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tabel != null)
                                            @foreach ($tabel as $key => $item)
                                                {{-- @dd($item) --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item[0]->nama_bulan }}</td>
                                                    <td>{{ round(($item->sum('target_kegiatan') / 100) * 100, 2) }}%</td>
                                                    <td>{{ round(($item->sum('kegiatan_bulan_sekarang') / 100) * 100, 2) }}%
                                                    </td>
                                                    <td>Rp.{{ number_format($item->sum('target_keuangan'), 0) }}</td>
                                                    <td>Rp.{{ number_format($item->sum('keuangan_bulan_sekarang'), 0) }}
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $sebelum = (int) $item->sum('keuangan_bulan_sebelumnya');
                                                        $sekarang = (int) $item->sum('keuangan_bulan_sekarang');
                                                        $total = $sebelum + $sekarang;
                                                        $persen = ($total / $item->sum('nominal_anggaran')) * 100;
                                                        ?>
                                                        {{ round($persen, 2) }}%
                                                    </td>
                                                    <td>
                                                        @foreach ($item as $k => $val)
                                                        @endforeach
                                                        @if ($val->status == 1)
                                                            <button class="btn btn-fw btn-sm primary">MELAPOR</button>
                                                        @else
                                                            <button class="btn btn-fw btn-sm danger">TIDAK MELAPOR</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2"><strong>TOTAL</strong></td>
                                                <td>
                                                    <strong>100%</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ round(($rekap['jml_kegiatan'] / $rekap['target_kegiatan']) * 100, 2) }}%</strong>
                                                </td>
                                                <td><strong>Rp.{{ number_format($rekap['anggaran'], 2) }}</strong>
                                                </td>
                                                <td><strong>Rp.{{ number_format($rekap['jml_keuangan'], 2) }}</strong>
                                                </td>
                                                <td><strong>{{ round(($rekap['jml_keuangan'] / $rekap['anggaran']) * 100, 2) }}%</strong>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $("#table").DataTable();
        });
    </script>
@endpush
