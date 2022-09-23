<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

    <title>COVER</title>
</head>

<body>
    <div class="text-center mt-2">
        <img src="{{ asset('storage/uploads/lambang.jpg') }}" alt="logo" class="float-start"
            style="max-width: 120px; margin-left: 8%; margin-right: -50%">
        <div>
            <h5>HASIL EVALUASI {{ $data['dana']->nama_sumber_dana }}</h5>
            <h5>{{ strtoupper($data['bulan']->nama_bulan) }} TAHUN ANGGARAN {{ $data['tag']->tahun_anggaran }}</h5>
            <h5>BAGIAN {{ strtoupper($data['skpd']->nama_skpd) }}</h5><br/>
            <hr>
        </div>
    </div>
    <div class="container-sm">
        <ol>
            <li>
                <div class="row">
                    <div class="col"><strong>Jumlah Paket Sub Kegiatan </strong></div>
                    <div class="col-md-2 col-sm-2"><span>:
                            {{ isset($main) == true ? count($main->groupBy('sub_kegiatan_id')) : '' }}</span></div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col"><strong>Jumlah Anggaran </strong></div>
                    <div class="col-md-2 col-sm-2">
                        <span>:
                            <?php
                            $nominal = 0;
                            foreach ($main->groupBy('nominal_anggaran') as $key => $value) {
                                $nominal += $key;
                            }
                            ?>
                            Rp.{{ number_format($nominal, 2) }}
                        </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col"><strong>Realisasi Keuangan s/d Bulan ini </strong></div>
                    <div class="col-md-2 col-sm-2">
                        <span>:
                            {{ $nominal > 0 ? round(($realKeuangan / $nominal) * 100, 2) : 0 }}%
                        </span>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col">
                        <strong>Rata-rata Realisasi Fisik Sub Kegiatan </strong>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <span>:
                            {{ round(($realKegiatan / 100) * 100, 2) }}%
                        </span>
                    </div>
                </div>
            </li>
            <li><strong>Klasifikasi Realisasi Paket Sub Kegiatan</strong></li>
            <ul>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>a. Paket Sub Kegiatan 0%</strong>
                            <ul>
                                <?php $count = []; ?>
                                @foreach ($main->groupBy('sub_kegiatan_id') as $key => $value)
                                    <?php $klas = 0; ?>
                                    @foreach ($value as $k => $v)
                                        @if ($v->bulan_id <= $data['bulan']->id)
                                            <?php $klas += $v->keuangan_bulan_sekarang; ?>
                                        @endif
                                    @endforeach
                                    @if (round(($klas / $nominal) * 100) == floatval(0))
                                        <?php array_push($count, [$key]); ?>
                                        <li>{{ $v->nama_sub_kegiatan }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ count($count) }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>b. Paket Sub Kegiatan 0% < x < 25%</strong>
                                    <ul>
                                        <?php $count = []; ?>
                                        @foreach ($main->groupBy('sub_kegiatan_id') as $key => $value)
                                            <?php $klas = 0; ?>
                                            @foreach ($value as $k => $v)
                                                @if ($v->bulan_id <= $data['bulan']->id)
                                                    <?php $klas += $v->keuangan_bulan_sekarang; ?>
                                                @endif
                                            @endforeach
                                            @if (round(($klas / $nominal) * 100) >= floatval(0) && round(($klas / $nominal) * 100) <= floatval(25))
                                                <?php array_push($count, [$key]); ?>
                                                <li>{{ $v->nama_sub_kegiatan }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ count($count) }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>c. Paket Sub Kegiatan 25% s/d 50%</strong>
                            <ul>
                                <?php $count = []; ?>
                                @foreach ($main->groupBy('sub_kegiatan_id') as $key => $value)
                                    <?php $klas = 0; ?>
                                    @foreach ($value as $k => $v)
                                        @if ($v->bulan_id <= $data['bulan']->id)
                                            <?php $klas += $v->keuangan_bulan_sekarang; ?>
                                        @endif
                                    @endforeach
                                    @if (round(($klas / $nominal) * 100) >= floatval(25) && round(($klas / $nominal) * 100) <= floatval(50))
                                        <?php array_push($count, [$key]); ?>
                                        <li>{{ $v->nama_sub_kegiatan }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ count($count) }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>d. Paket Sub Kegiatan 50% s/d 75%</strong>
                            <ul>
                                <?php $count = []; ?>
                                @foreach ($main->groupBy('sub_kegiatan_id') as $key => $value)
                                    <?php $klas = 0; ?>
                                    @foreach ($value as $k => $v)
                                        @if ($v->bulan_id <= $data['bulan']->id)
                                            <?php $klas += $v->keuangan_bulan_sekarang; ?>
                                        @endif
                                    @endforeach
                                    @if (round(($klas / $nominal) * 100) >= floatval(50) && round(($klas / $nominal) * 100) <= floatval(75))
                                        <?php array_push($count, [$key]); ?>
                                        <li>{{ $v->nama_sub_kegiatan }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ count($count) }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>e. Paket Sub Kegiatan 75% < 100% </strong>
                                    <ul>
                                        <?php $count = []; ?>
                                        @foreach ($main->groupBy('sub_kegiatan_id') as $key => $value)
                                            <?php $klas = 0; ?>
                                            @foreach ($value as $k => $v)
                                                @if ($v->bulan_id <= $data['bulan']->id)
                                                    <?php $klas += $v->keuangan_bulan_sekarang; ?>
                                                @endif
                                            @endforeach
                                            @if (round(($klas / $nominal) * 100) >= floatval(75) && round(($klas / $nominal) * 100) <= floatval(100))
                                                <?php array_push($count, [$key]); ?>
                                                <li>{{ $v->nama_sub_kegiatan }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ count($count) }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>f. Paket Sub Kegiatan 100%</strong>
                            <ul>
                                <?php $count = []; ?>
                                @foreach ($main->groupBy('sub_kegiatan_id') as $key => $value)
                                    <?php $klas = 0; ?>
                                    @foreach ($value as $k => $v)
                                        @if ($v->bulan_id <= $data['bulan']->id)
                                            <?php $klas += $v->keuangan_bulan_sekarang; ?>
                                        @endif
                                    @endforeach
                                    @if (round(($klas / $nominal) * 100) == floatval(100))
                                        <?php array_push($count, [$key]); ?>
                                        <li>{{ $v->nama_sub_kegiatan }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ count($count) }}</span>
                        </div>
                    </div>
                </li>
            </ul>
        </ol>
    </div>
</body>
<script>
    // window.print();
</script>

</html>
