@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [KUNCI INPUT AKTIVASI]</h1>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA</th>
                                            <th>TANGGAL AKTIF</th>
                                            <th>TANGGAL NONAKTIF</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $s)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $s->nama_inputan }}</td>
                                                <td>{{ $s->aktif }}</td>
                                                <td>{{ $s->tidak_aktif }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="{{ url('/admin/aktivasi/kunci') . '/' . $s->id }}"
                                                            method="POST">
                                                            @csrf
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm {{ $s->status == 0 ? 'red' : 'indigo' }}"
                                                                role="button">
                                                                <i
                                                                    class="bi {{ $s->status == 0 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                                            </button>
                                                        </form>
                                                    </div>
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
