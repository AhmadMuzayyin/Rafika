<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    <title>GRAFIK</title>

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
    <input type="hidden" name="dana" value="{{ $dana->id }}">
    <input type="hidden" name="bulan" value="{{ $bl->id }}">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart" style='width:300px !important;height:300px !important'></canvas>
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
{{-- ChartsJS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"
    integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const data = {
        labels: ["Kegiatan", "Keuangan"],
        datasets: [{
                label: 'Target (%)',
                data: [{{ $grafik['tarkegiatan'] }}, {{ $grafik['tarkeuangan'] }}],
                backgroundColor: 'rgb(54,162,235)',
            },
            {
                label: 'Realisasi (%)',
                data: [{{ $grafik['relkegiatan'] }}, {{ $grafik['relkeuangan'] }}],
                backgroundColor: 'rgb(255,71,111)',
            }
        ]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Grafik Realisasi dan Target Kegiatan dan Keuangan Sampai Bulan Sekarang'
                },
            },
            responsive: true,
            interaction: {
                intersect: false,
            },
        }
    };
    const myChart = new Chart(document.getElementById('myChart').getContext('2d'), config);
</script>

</html>
