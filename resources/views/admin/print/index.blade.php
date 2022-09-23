<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    @if ($print == 'pengadaan')
        @foreach ($data as $key => $item)
            <h5 class="text-center">DAFTAR KEGIATAN {{ $dana }}<br>
                TAHUN ANGGARAN
                {{ $item[$key-1]->pak->tahun_anggaran }}<br> BAGIAN {{ strtoupper($item[$key-1]->user->nama_skpd) }}
                <br>
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Pelaksanaan</th>
                        <th scope="col">Program Prioritas Bupati</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item as $val)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $val->nama_sub_kegiatan }}</td>
                            <td>Rp.
                                @foreach ($val->anggaran as $value)
                                    @if ($value->pelaksanaan == session()->get('pelaksanaan'))
                                        {{ number_format($value->nominal_anggaran, 2) }}
                                    @endif
                                @endforeach
                            </td>
                            <td>{{ $val->pelaksanaan->nama_pelaksanaan }}</td>
                            <td>{{ $val->program_bupati }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    @elseif ($print == 'dau' || $print == 'dak' || $print == 'dbhc')
        @foreach ($data as $key => $item)
            <h5 class="text-center">DAFTAR KEGIATAN SUMBER DANA {{ $item[$key-1]->sumber_dana->nama_sumber_dana }}<br>
                TAHUN
                ANGGARAN
                {{ $item[$key-1]->pak->tahun_anggaran }}<br> BAGIAN {{ strtoupper($item[$key-1]->user->nama_skpd) }}
            </h5>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Sub Kegiatan</th>
                            <th scope="col">Anggaran</th>
                            <th scope="col">Pelaksanaan</th>
                            <th scope="col">Program Prioritas Bupati</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item as $val)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $val->nama_sub_kegiatan }}</td>
                                <td>Rp.
                                    @foreach ($val->anggaran as $value)
                                        @if ($value->pelaksanaan == session()->get('pelaksanaan'))
                                            {{ number_format($value->nominal_anggaran, 2) }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{ $val->pelaksanaan->nama_pelaksanaan }}</td>
                                <td>{{ $val->program_bupati }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    @endif
    @if ($print == 'kendala')
        <h5 class="text-center">DAFTAR KEGIATAN {{ strtoupper($dana) }}<br> TAHUN
            ANGGARAN
            {{ $thn->tahun_anggaran }}<br> BAGIAN {{ strtoupper(Auth()->user()->nama_skpd) }}
        </h5>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Sub Kegiatan</th>
                    <th scope="col">Anggaran</th>
                    <th scope="col">Pelaksanaan</th>
                    <th scope="col">Kendala</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $item->nama_sub_kegiatan }}</td>
                        <td>Rp.
                            @foreach ($item->anggaran as $val)
                                @if ($val->pelaksanaan == session()->get('pelaksanaan'))
                                    {{ number_format($val->nominal_anggaran, 2) }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $item->pelaksanaan->nama_pelaksanaan }}</td>
                        <td>
                            @foreach ($item->jadwal as $kendala)
                                @if ($kendala->kendala != null)
                                    {{ $kendala->kendala . ', ' }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
</script>

</html>
