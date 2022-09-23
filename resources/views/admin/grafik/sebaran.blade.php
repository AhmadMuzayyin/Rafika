@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [SEBARAN KEGIATAN]</h1>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md col-lg">
                                    <div id="googleMap" style="width:100%;height:380px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ############ PAGE END-->
            </div>
            <div class="row">
                <div class="col">
                    <div class="box">
                        <div class="box-body">
                            <span class="justify-content-center">
                                <canvas id="myChart" style='width:350px !important;height:350px !important'></canvas>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ ENV('MAP_KEY') }}"></script>
    <script>
        $(document).ready(function() {
            $("#table").DataTable();
        });

        $(document).ready(function() {
            $.ajax({
                type: 'GET',
                url: '{{ url('/admin/grafik/sebaranData') }}',
                success: function(res) {
                    // Map
                    const lokasi = res.data.map(v => {
                        return {
                            lat: parseFloat(v.latitude),
                            long: parseFloat(v.longitude),
                        }
                    })
                    let map = new google.maps.Map(document.getElementById('googleMap'), {
                        zoom: 10,
                        center: new google.maps.LatLng(lokasi[0].lat, lokasi[0].long),
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });
                    for (i = 0; i < lokasi.length; i++) {
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(lokasi[i].lat, lokasi[i]
                                .long),
                            map: map
                        });
                    }

                    // Chart Map
                    const ctx = document.getElementById('myChart').getContext('2d');
                    const labels = [];
                    const dataset = [];
                    res.kec.forEach(function(value) {
                        labels.push(value.label)
                        dataset.push(value.data)
                    });
                    const data = {
                        labels: labels,
                        datasets: [{
                            axis: 'y',
                            label: 'Grafik Sebaran By Kecamatan',
                            data: dataset,
                            fill: false,
                            backgroundColor: [
                                'rgb(255,69,109)',
                                'rgb(54,162,235)',
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
