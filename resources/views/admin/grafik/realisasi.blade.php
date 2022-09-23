@extends('template.main')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [GRAFIK REALISASI]</h1>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-lg col-md col-sm">
                                    <label for="bulan">BULAN:</label>
                                    <select class="custom-select form-control" id="bulanSelect">
                                        @foreach ($bulan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->get('bulan') ? ($item->id == request()->get('bulan') ? 'selected' : '') : ($item->id == $selected ? 'selected' : '') }}>
                                                {{ $item->nama_bulan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Grafik RAFIKA --}}
            @include('admin.grafik.RealisasiAdmin.rafika')
            {{-- Grafik Pengadaan --}}
            @include('admin.grafik.RealisasiAdmin.grafikPengadaan')
            {{-- Grafik Sumber Dana --}}
            @include('admin.grafik.RealisasiAdmin.dana')
        </div>
        <!-- ############ PAGE END-->
    </div>
@endsection

@push('script')
    <script src="{{ url('assets/libs/jquery/jquery.easy-pie-chart/dist/jquery.easypiechart.fill.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".easyPieChart").easyPieChart({
                lineWidth: 5,
                trackColor: 'transparent',
                scaleColor: 'transparent',
                size: 80,
                scaleLength: 0,
            });
        });
        $(document).ready(function() {
            $("#bulanSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var pengadaan = {{ request()->get('pengadaan') ?? 1 }};
                var dana = {{ request()->get('dana') ?? 1 }};
                window.location.href = '{{ url('/admin/realisasi') }}?bulan=' + bulan + '&pengadaan=' +
                    pengadaan + '&dana=' + dana;
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
