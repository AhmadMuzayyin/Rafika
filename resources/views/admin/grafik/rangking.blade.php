@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [RANKING REALISASI
                                {{ request()->get('filter') ? (request()->get('filter') == 1 ? 'KEGIATAN' : 'KEUANGAN') : 'KEGIATAN' }}]
                            </h1>
                        </div>
                        <div class="box-tool">
                            <ul class="nav">
                                <li class="nav-item inline dropdown">
                                    <a class="nav-link" data-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons md-18"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-scale pull-right">
                                        <a class="dropdown-item"
                                            href="{{ url('/admin/grafik/ranking?bulan=') . (request()->get('bulan') ?? 1) . '&dana=' . (request()->get('dana') ?? 1) . '&skpd=' . (request()->get('skpd') ?? 1) . '&filter=1' }}">
                                            Realisasi Kegiatan
                                        </a>
                                        <a class="dropdown-item"
                                            href="{{ url('/admin/grafik/ranking?bulan=') . (request()->get('bulan') ?? 1) . '&dana=' . (request()->get('dana') ?? 1) . '&skpd=' . (request()->get('skpd') ?? 1) . '&filter=2' }}">
                                            Realisasi Keuangan
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="box-body">
                            {{-- Row --}}
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
                            {{-- End Row --}}
                            <div class="row">
                                <div class="col">
                                    <span class="justify-content-center">
                                        <canvas id="myChart"
                                            style='width:350px !important;height:350px !important'></canvas>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ############ PAGE END-->
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#bulanSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();
                var filter = {{ request()->get('filter') ?? 1 }};
                window.location.href = '{{ url('/admin/grafik/ranking') }}?bulan=' +
                    bulan + '&dana=' + dana + '&skpd=' + skpd + '&filter=' + filter;
            });
        });
        $(document).ready(function() {
            $("#danaSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();
                var filter = {{ request()->get('filter') ?? 1 }};
                window.location.href = '{{ url('/admin/grafik/ranking') }}?bulan=' +
                    bulan + '&dana=' + dana + '&skpd=' + skpd + '&filter=' + filter;
            });
        });
        $(document).ready(function() {
            $("#skpdSelect").change(function() {
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();
                var filter = {{ request()->get('filter') ?? 1 }};
                window.location.href = '{{ url('/admin/grafik/ranking') }}?bulan=' +
                    bulan + '&dana=' + dana + '&skpd=' + skpd + '&filter=' + filter;
            });
        });
        // grafik
        $(document).ready(function() {
            var bulan = {{ request()->get('bulan') ?? 1 }};
            var dana = {{ request()->get('dana') ?? 1 }};
            var skpd = {{ request()->get('skpd') ?? 1 }};
            var filter = {{ request()->get('filter') ?? 1 }};
            $.ajax({
                type: 'GET',
                url: '{{ url('/admin/grafik/rankingData?bulan=') }}' + bulan + '&dana=' + dana + '&skpd=' +
                    skpd + '&filter=' + filter,
                success: function(res) {
                    const ctx = document.getElementById('myChart').getContext('2d');
                    const labels = [];
                    const dataset = [];
                    res.forEach(function(value) {
                        labels.push(value.key)
                        dataset.push(value.data)
                    });
                    const data = {
                        labels: labels,
                        datasets: [{
                            axis: 'y',
                            label: 'Realisasi',
                            data: dataset,
                            fill: false,
                            backgroundColor: [
                                'rgb(255,69,109)',
                            ],
                        }]
                    };
                    const myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            indexAxis: 'y',
                            maintainAspectRatio: false,
                        }
                    });
                }
            });
        });
    </script>
@endpush
