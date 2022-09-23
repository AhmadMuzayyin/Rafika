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
                            <div class="row">
                                <div class="col-md col-sm col-lg">
                                    <label for="bulan">BULAN:</label>
                                    <select class="form-control" id="bulanSelect" name="bulanSelect">
                                        @foreach ($bulan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $selected ? 'selected' : '' }}>
                                                {{ $item->nama_bulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="skpd">SKPD:</label>
                                    <select class="form-control @error('skpdSelect') parsley-error @enderror"
                                        id="skpdSelect" name="skpdSelect">
                                        <option value="all" {{ request()->get('skpd') == 'all' ? 'selected' : '' }}>
                                            SELURUH SKPD</option>
                                        <option value="1" {{ request()->get('skpd') == '1' ? 'selected' : '' }}>
                                            Sekretariat Daerah
                                        </option>
                                        <option value="2" {{ request()->get('skpd') == '2' ? 'selected' : '' }}>Dinas
                                        </option>
                                        <option value="3" {{ request()->get('skpd') == '3' ? 'selected' : '' }}>Badan
                                        </option>
                                        <option value="4" {{ request()->get('skpd') == '4' ? 'selected' : '' }}>Kantor
                                        </option>
                                        <option value="5" {{ request()->get('skpd') == '5' ? 'selected' : '' }}>
                                            Kecamatan</option>
                                    </select>
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="dana">SUMBER DANA:</label>
                                    <select class="form-control" id="danaSelect" name="danaSelect">
                                        @foreach ($dana as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $selectedDana ? 'selected' : '' }}>
                                                {{ $item->nama_sumber_dana }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">No</th>
                                            <th rowspan="3">OPD</th>
                                            <th rowspan="3">ANGGARAN</th>
                                            <th rowspan="3">PAKET</th>
                                            <th colspan="2" class="text-center">KEGIATAN</th>
                                            <th colspan="2" class="text-center">KEUANGAN</th>
                                            <th rowspan="3">STATUS</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">TARGET</th>
                                            <th rowspan="2">REALISASI</th>
                                        </tr>
                                        <tr>
                                            <th>TARGET</th>
                                            <th>REALISASI</th>
                                            {{-- <th>PERSENTASE</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($tabel != null)
                                            @foreach ($tabel as $key => $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item[0]->nama_skpd }}</td>
                                                    <td>Rp.{{ number_format($anggaran, 2) }}</td>
                                                    <td>{{ $rekap['jml_paket'] }}</td>
                                                    <td>{{ round(($item->sum('target_kegiatan') / 100) * 100, 2) }}%</td>
                                                    <td>{{ round(($item->sum('kegiatan_bulan_sekarang') / 100) * 100, 2) }}%
                                                    </td>
                                                    <td>Rp.{{ number_format($item->sum('target_keuangan'), 0) }}</td>
                                                    <td>Rp.{{ number_format($item->sum('keuangan_bulan_sekarang'), 0) }}
                                                    </td>
                                                    {{-- <td> --}}
                                                    <?php
                                                    // $sebelum = (int) $item->sum('keuangan_bulan_sebelumnya');
                                                    // $sekarang = (int) $item->sum('keuangan_bulan_sekarang');
                                                    // $total = $sebelum + $sekarang;
                                                    // $persen = ($total / $item->sum('nominal_anggaran')) * 100;
                                                    ?>
                                                    {{-- {{ round($persen, 2) }}% --}}
                                                    {{-- </td> --}}
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
                                            {{-- For Total --}}
                                            {{-- <tr>
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
                                            </tr> --}}
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
        $(document).ready(function() {
            $("#bulanSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();
                window.location.href = '{{ url('/admin/rekapitulasi') }}?bulan=' +
                    bulan + '&dana=' + dana + '&skpd=' + skpd;
            });
        });
        $(document).ready(function() {
            $("#danaSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();
                window.location.href = '{{ url('/admin/rekapitulasi') }}?bulan=' +
                    bulan + '&dana=' + dana + '&skpd=' + skpd;
            });
        });
        $(document).ready(function() {
            $("#skpdSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();
                window.location.href = '{{ url('/admin/rekapitulasi') }}?bulan=' +
                    bulan + '&dana=' + dana + '&skpd=' + skpd;
            });
        });
    </script>
@endpush
