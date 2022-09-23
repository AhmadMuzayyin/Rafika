@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        {{-- @dd(session()->get('pak_id')) --}}
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [SUB KEGIATAN]</h1>
                        </div>
                        <div class="box-body">
                            @if ($aktif->status != 0)
                                @if (session()->get('pelaksanaan') == 0)
                                    <a href="{{ url('/operator/subkegiatan/create') }}"
                                        class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                        role="button">TAMBAH</a>
                                @endif
                            @else
                                <div class="alert alert-danger" role="alert">
                                    Inputan dinonaktifkan, silahkan hubungi admin!
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NOMOR REKENING</th>
                                            <th>SUB KEGIATAN</th>
                                            <th>ANGGARAN</th>
                                            <th>DANA</th>
                                            <th>KETERANGAN</th>
                                            @if (Auth()->user()->isAdmin == false)
                                                <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $k)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $k->rekening }}</td>
                                                <td>{{ $k->nama_sub_kegiatan }}</td>
                                                <td id="tdanggara">
                                                    @foreach ($k->anggaran as $ag)
                                                        @if ($ag->pelaksanaan == session()->get('pelaksanaan'))
                                                            Rp. {{ number_format($ag->nominal_anggaran, 2) }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{ $k->sumber_dana->nama_sumber_dana }}</td>
                                                <td>
                                                    @foreach ($k->anggaran as $ag)
                                                        @if ($ag->pelaksanaan == session()->get('pelaksanaan'))
                                                            @if ($ag->nominal_anggaran >= 250000000)
                                                                LELANG
                                                            @else
                                                                NON LELANG
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </td>
                                                @if (Auth()->user()->isAdmin == false)
                                                    <td>
                                                        @if ($aktif->status != 0)
                                                            <div class="btn-group">
                                                                <form
                                                                    action="{{ url('/operator/subkegiatan/edit') . '/' . $k->id }}"
                                                                    method="GET" class=" d-inline-block">
                                                                    <button type="submit"
                                                                        class="md-btn md-raised m-b-sm blue" role="button"
                                                                        style="border: 0px">
                                                                        <i class="bi bi-pencil-square"></i>
                                                                    </button>
                                                                </form>
                                                                <form
                                                                    action="{{ url('/operator/subkegiatan/destroy') . '/' . $k->id }}"
                                                                    class=" d-inline-block mx-2" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="md-btn md-raised m-b-sm red deleteActivity"
                                                                        role="button" style="border: 0px">
                                                                        <i class="bi bi-trash-fill"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endif
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
