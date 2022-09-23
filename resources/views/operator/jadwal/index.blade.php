@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [SCHEDULE]</h1>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>REKENING</th>
                                            <th>NAMA KEGIATAN</th>
                                            <th>PROGRES SCHEDULE</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $key => $s)
                                            {{-- @dd($data) --}}
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $s->rekening }}</td>
                                                <td>{{ $s->nama_sub_kegiatan }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                            role="progressbar"
                                                            aria-valuenow="{{ \helper::GetPersent($s->id) }}" aria-valuemin="0" aria-valuemax="{{ \helper::GetPersent($s->id) }}" style="width: {{ \helper::GetPersent($s->id) }}%">
                                                            Complete {{ \helper::GetPersent($s->id) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if (Auth()->user()->isAdmin != 1)
                                                        <a href="{{ url('/operator/jadwal/edit/lokasi') . '/' . $s->id . '?_token=Rafika@token#928Jancuk@2022$Lokasi' }}"
                                                            type="submit" class="md-btn md-raised m-b-sm blue"
                                                            role="button" style="border: 0px">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                    @endif
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
    </script>
@endpush
