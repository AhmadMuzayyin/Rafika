@extends('template.main')
@section('content')
    <div ui-view class="app-body" id="view">
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">

                            <div class="row">
                                <div class="col-md col-sm col-lg my-2">
                                    <a href="{{ url('/operator/jadwal') }}" class="md-btn md-raised m-b-sm blue"
                                        role="button">
                                        <i class="bi bi-arrow-left"></i> Kembali
                                    </a>
                                </div>

                                <div class="col-md col-sm col-lg my-2">
                                    <a href="{{ url('/operator/jadwal/edit/lokasi') . '/' . $data->id . '?_token=' . $token }}"
                                        class="md-btn md-raised m-b-sm {{ $page == 'lokasi' ? 'indigo' : 'blue' }}"
                                        role="button">
                                        <i class="bi bi-geo-alt-fill"></i> LOKASI
                                    </a>
                                </div>


                                <div class="col-md col-sm col-lg my-2">
                                    <a href="{{ url('/operator/jadwal/edit/volume') . '/' . $data->id . '?_token=' . $token }}"
                                        class="md-btn md-raised m-b-sm {{ $page == 'volume' ? 'indigo' : 'blue' }}"
                                        role="button">
                                        <i class="bi bi-hourglass-split"></i> VOLUME
                                    </a>
                                </div>


                                <div class="col-md col-sm col-lg my-2 mr-md-5 mr-sm-auto">
                                    <a href="{{ url('/operator/jadwal/edit/pptk') . '/' . $data->id . '?_token=' . $token }}"
                                        class="md-btn md-raised m-b-sm {{ $page == 'pptk' ? 'indigo' : 'blue' }}"
                                        role="button">
                                        <i class="bi bi-people-fill"></i> PENANGGUNG JAWAB
                                    </a>
                                </div>


                                <div class="col-md col-sm col-lg my-2">
                                    <a href="{{ url('/operator/jadwal/edit/target') . '/' . $data->id . '?_token=' . $token }}"
                                        class="md-btn md-raised m-b-sm {{ $page == 'target' ? 'indigo' : 'blue' }}"
                                        role="button">
                                        <i class="bi bi-grid-1x2-fill"></i> TARGET
                                    </a>
                                </div>
                            </div>

                        </div>

                        <div class="box-body">
                            <div class="card text-white text-center mb-3"
                                style="max-width: 100em; max-height: 30em; background-color: #2E3E4E">
                                <div class="card-body">
                                    <h1 style="margin-top: 25px; margin-bottom: 25px">{{ $data->rekening }}
                                        |
                                        {{ $data->nama_sub_kegiatan }}</h1>
                                </div>
                            </div>
                            @if ($page == 'lokasi')
                                @include('operator.jadwal.lokasi')
                            @elseif ($page == 'volume')
                                @include('operator.jadwal.volume')
                            @elseif ($page == 'pptk')
                                @include('operator.jadwal.pptk')
                            @elseif ($page == 'target')
                                @include('operator.jadwal.keuangan')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
