@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">

                        <div class="box-header">
                            <h1>DATA [LAPORAN REALISASI KEGIATAN]</h1>
                            <form>
                                <div class="row mt-5">
                                    @csrf
                                    {{-- @dd($bulan) --}}
                                    <div class="col-md col-sm col-lg">
                                        <label for="bulan">BULAN:</label>
                                        <select class="form-control" id="bulanSelect" name="bulanSelect">
                                            @for ($i = 0; $i < $batas; $i++)
                                                <option value="{{ $bulan[$i]->id }}"
                                                    {{ $bulan[$i]->id == $selected->id ? 'selected' : '' }}>
                                                    {{ $bulan[$i]->nama_bulan }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="dana">SUMBER DANA:</label>
                                        <select class="form-control" id="danaSelect" name="danaSelect">
                                            @foreach ($dana as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $danaSelect == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_sumber_dana }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="box-body">
                            @if (session('report'))
                                <div class="alert alert-warning" role="alert">
                                    {{ session('report') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered justify-content-centery align-items-center"
                                    id="table">
                                    <thead>
                                        <tr>
                                            <th class="tg-0pky" rowspan="2">No</th>
                                            <th class="tg-0pky" rowspan="2">SUB KEGIATAN</th>
                                            <th class="tg-0pky" colspan="2">KEGIATAN(%)</th>
                                            <th class="tg-0pky" colspan="2">KEUANGAN(Rp.)</th>
                                            <th class="tg-0pky" rowspan="2">KENDALA</th>
                                        </tr>
                                        <tr>
                                            <th class="tg-0pky">TARGET</th>
                                            <th class="tg-0pky">REALISASI</th>
                                            <th class="tg-0pky">SISA</th>
                                            <th class="tg-0pky">REALISASI</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body_report">
                                        @foreach ($data as $item)
                                            <tr class="data-r">
                                                <input type="hidden" class="form-control" name="id[]"
                                                    value="{{ $item->id }}">
                                                <td id="no">{{ $loop->iteration }}</td>
                                                <td id="kegiatan" style="font-size: 80%">
                                                    {{ $item->nama_sub_kegiatan }}</td>

                                                <td id="klalu">
                                                    {{ $item->target_kegiatan }}%
                                                </td>
                                                <td id="inkegiatan" class="text-center">
                                                    <input type="number" name="kegiatan[]" id="inputkegiatan"
                                                        class="{{ $item->kegiatan_bulan_sekarang < $item->target_kegiatan ? 'text-danger' : 'text-dark' }}"
                                                        style="max-width: 25px;"
                                                        value="{{ $item->kegiatan_bulan_sekarang }}">
                                                </td>
                                                <td id="anggaran">
                                                    Rp.{{ number_format($item->nominal_anggaran - helper::sisa($item->sub_kegiatan_id), 0) }}
                                                </td>
                                                <td id="keuangan" class="text-center">
                                                    <input type="number" name="keuangan[]" id="keuangan"
                                                        class="{{ $item->keuangan_bulan_sekarang < $item->target_keuangan ? 'text-danger' : 'text-dark' }}"
                                                        style="max-width: 80px;"
                                                        value="{{ $item->keuangan_bulan_sekarang }}">
                                                </td>
                                                <td id="kendala">
                                                    <input type="text" name="kendala[]" id="kendala"
                                                        value="{{ $item->kendala }}" style="max-width: 80px">
                                                </td>
                                            </tr>
                                        @endforeach
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
                var _token = $("input[name='_token']").val();
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                window.location.href = '{{ url('/admin/report') }}?bulan=' +
                    bulan + '&dana=' + dana;
            });
        });
        $(document).ready(function() {
            $("#danaSelect").change(function() {
                var _token = $("input[name='_token']").val();
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                window.location.href = '{{ url('/admin/report') }}?bulan=' +
                    bulan + '&dana=' + dana;
            });
        });
    </script>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
