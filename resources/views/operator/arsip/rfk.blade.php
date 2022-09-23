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
    <title>RFK</title>
</head>

<body>
    <div class="text-center mt-2">
        <img src="{{ asset('storage/uploads/lambang.jpg') }}" alt="logo" class="float-start"
            style="max-width: 120px; margin-left: 13%; margin-right: -50%">
        <div>
            <h5>PEMERINTAH KABUPATEN PAMEKASAN {{ strtoupper($dana->nama_sumber_dana) }}</h5>
            <h5>REALISASI KEGIATAN DAN KEUANGAN</h5>
            <h5>BULAN {{ strtoupper($bl->nama_bulan) }} ANGGARAN {{ $thn }}</h5>
            <h5>BAGIAN {{ strtoupper(Auth()->user()->nama_skpd) }}</h5>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive-xl">
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th class="text-center" rowspan="2">NO</th>
                            <th class="text-center" rowspan="2">NAMA SUB KEGIATAN</th>
                            <th class="text-center" rowspan="2">ANGGARAN (Rp.)</th>
                            <th class="text-center" rowspan="2">BOBOT</th>
                            <th class="text-center" rowspan="2">VOLUME</th>
                            <th class="text-center" rowspan="2">LOKASI</th>
                            <th class="text-center" rowspan="2">PPTK</th>
                            <th class="text-center" rowspan="2">JENIS PENGADAAN</th>
                            <th class="text-center" colspan="2">REALISASI KEGIATAN</th>
                            <th class="text-center" colspan="4">REALISASI KEUANGAN</th>
                        </tr>
                        <tr>
                            <th class="text-center">TARGET</th>
                            <th class="text-center">LAPORAN</th>
                            <th class="text-center">TARGET</th>
                            <th class="text-center">LAPORAN(%)</th>
                            <th class="text-center">LAPORAN(Rp.)</th>
                            <th class="text-center">SISA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nominal = 0;
                        $anggaran = [];
                        $jmlTarget = [];
                        $jmlLpTarget = [];
                        $jmlSisa = 0;
                        $jmlKeuanganLP = [];
                        $jmlKeuangaper = [];
                        $jmlKeuanganTarget = [];
                        foreach ($data as $fal) {
                            foreach ($fal->anggaran as $agr) {
                                if ($agr->pelaksanaan == session()->get('pelaksanaan')) {
                                    array_push($anggaran, $agr->nominal_anggaran);
                                }
                            }
                        }
                        foreach ($anggaran as $nom) {
                            $nominal += $nom;
                        }
                        ?>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center" style="font-size: 90%">{{ $loop->iteration }}</td>
                                <td class="text-center" style="font-size: 90%" style="font-size: 80%">
                                    {{ $item->nama_sub_kegiatan }}
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    @foreach ($item->anggaran as $pal)
                                        @if ($pal->pelaksanaan == session()->get('pelaksanaan'))
                                            {{ number_format($pal->nominal_anggaran, 2) }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    @foreach ($item->anggaran as $bobot)
                                        @if ($bobot->pelaksanaan == session()->get('pelaksanaan'))
                                            {{ round((($bobot->nominal_anggaran / $nominal) * 100) / 100, 2) }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center" style="font-size: 90%">{{ strtoupper(1 . ' PAKET') }}</td>
                                <td class="text-center" style="font-size: 90%" style="font-size: 80%">
                                    <?php $lokasi = [];
                                    $numb = 1; ?>
                                    @foreach ($item->lokasi as $lok)
                                        {{ $numb++ }}. {{ $lok->alamat }} <br>
                                    @endforeach
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    @foreach ($item->penanggung_jawab->load('user_penanggun_jawab') as $pn)
                                        {{ strtoupper($pn->user_penanggun_jawab->nama_penanggung_jawab) }}
                                    @endforeach
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    {{ $item->pengadaan->nama_pengadaan }}
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    <?php $tgk = 0; ?>
                                    @php
                                        foreach ($item->jadwal as $tgkt) {
                                            if ($tgkt->bulan_id <= $bl->id) {
                                                $tgk += $tgkt->target_kegiatan;
                                            }
                                        }
                                        array_push($jmlTarget, $tgk);
                                    @endphp
                                    {{ round($tgk, 2) }}%
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    <?php $kgt = 0; ?>
                                    @php
                                        foreach ($item->jadwal as $lpkg) {
                                            if ($lpkg->bulan_id <= $bl->id) {
                                                $kgt += $lpkg->kegiatan_bulan_sekarang;
                                            }
                                        }
                                        array_push($jmlLpTarget, $kgt);
                                    @endphp
                                    {{ round($kgt, 2) }}%
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    <?php $kg = 0; ?>
                                    @php
                                        foreach ($item->jadwal as $tr) {
                                            if ($tr->bulan_id <= $bl->id) {
                                                $kg += $tr->target_keuangan;
                                            }
                                        }
                                        array_push($jmlKeuanganTarget, $kg);
                                    @endphp
                                    {{ number_format($kg, 2) }}
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    <?php $nm = 0; ?>
                                    @php
                                        foreach ($item->jadwal as $pr) {
                                            if ($pr->bulan_id <= $bl->id) {
                                                $nm += $pr->keuangan_bulan_sekarang;
                                            }
                                        }
                                        array_push($jmlKeuangaper, ($nm / $nominal) * 100);
                                    @endphp
                                    {{ round(($nm / $nominal) * 100, 2) }}%
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    <?php $lp = 0; ?>
                                    @php
                                        foreach ($item->jadwal as $rp) {
                                            if ($rp->bulan_id <= $bl->id) {
                                                $lp += $rp->keuangan_bulan_sekarang;
                                            }
                                        }
                                        array_push($jmlKeuanganLP, $lp);
                                    @endphp
                                    {{ number_format($lp, 2) }}
                                </td>
                                <td class="text-center" style="font-size: 90%">
                                    <?php
                                    foreach ($item->anggaran as $getSS) {
                                        if ($getSS->pelaksanaan == session()->get('pelaksanaan')) {
                                            echo number_format($getSS->nominal_anggaran - $lp, 2);
                                            $jmlSisa += $getSS->nominal_anggaran - $lp;
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-center" colspan="2"><strong>JUMLAH</strong></td>
                            <td class="text-center">
                                <strong>{{ $nominal > 0 ? number_format($nominal, 2) : 0 }}</strong>
                            </td>
                            <td class="text-center"><strong>100</strong></td>
                            <td class="text-center"> </td>
                            <td class="text-center"> </td>
                            <td class="text-center"> </td>
                            <td class="text-center"> </td>
                            <td class="text-center">
                                <strong>
                                    @php
                                        $hsl = 0;
                                        foreach ($jmlTarget as $ttl) {
                                            $hsl += $ttl;
                                        }
                                    @endphp
                                    {{ round($hsl, 2) }}%
                                </strong>
                            </td>
                            <td class="text-center">
                                <strong>
                                    @php
                                        $tl = 0;
                                        foreach ($jmlLpTarget as $lpt) {
                                            $tl += $lpt;
                                        }
                                    @endphp
                                    {{ round($tl, 2) }}%
                                </strong>
                            </td>
                            <td class="text-center">
                                <strong>
                                    @php
                                        $ktg = 0;
                                        foreach ($jmlKeuanganTarget as $lpt) {
                                            $ktg += $lpt;
                                        }
                                    @endphp
                                    {{ number_format($ktg, 2) }}
                                </strong>
                            </td>
                            <td class="text-center">
                                <strong>
                                    @php
                                        $pers = 0;
                                        foreach ($jmlKeuangaper as $lpt) {
                                            $pers += $lpt;
                                        }
                                    @endphp
                                    {{ round($pers, 2) }}%
                                </strong>
                            </td>
                            <td class="text-center">
                                <strong>
                                    @php
                                        $jklp = 0;
                                        foreach ($jmlKeuanganLP as $lpt) {
                                            $jklp += $lpt;
                                        }
                                    @endphp
                                    {{ number_format($jklp, 2) }}
                                </strong>
                            </td>
                            <td class="text-center">
                                <strong>
                                    {{ number_format($jmlSisa, 2) }}
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-8"></div>
        <div class="col-md-4 col-lg-4 col-sm-4 mt-5">
            <p class="text-center">Pamekasan,
                {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                <br>Mengetahui, <br> Pimpinan OPD
            </p>
            <p class="text-center mt-5"><strong><u>{{ strtoupper(Auth()->user()->nama_kpa) }}</u></strong></p>
        </div>
    </div>
</body>
<script>
    // window.print();
</script>

</html>
