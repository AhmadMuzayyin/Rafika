@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [SUB KEGIATAN]</h1>
                        </div>
                        <div class="box-body">
                            @if (session()->get('pelaksanaan') == 1)
                                <div class="table-responsive">
                                    <ul>
                                        <li class="text-danger">Pastikan data SUB KEGIATAN sudah terinput semua!
                                        </li>
                                        <li class="text-danger">Inputkan total anggaran, bukan tambahan
                                            anggaran PAK saat ini!
                                        </li>
                                        <li class="text-danger">Inputkan semua Perubahan Anggaran, jika lebih dari 10
                                            dilanjut dengan next dan mengisi Perubahan Angggaran lalu klik simpan!
                                        </li>
                                    </ul>
                                    <form action="{{ url('/operator/perubahan') }}" method="POST">
                                        @csrf
                                        <table class="table" id="table-anggaran">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>SUB KEGIATAN</th>
                                                    <th>ANGGARAN SEBELUMNYA</th>
                                                    <th>ANGGARAN SEKARANG</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @dd($perubahan) --}}
                                                @foreach ($perubahan as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_sub_kegiatan }}</td>
                                                        <td>
                                                            @foreach ($item->anggaran as $ag)
                                                                Rp. {{ number_format($ag->nominal_anggaran, 2) }}
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                          <input type="hidden" name="id[]" value="{{ $item->id }}">
                                                            <input type="text" name="anggaran[]" value="{{ $ag->nominal_anggaran }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <button type="submit" class="md-btn md-raised m-b-sm w-xs blue AddPerubahan"
                                            role="button">SIMPAN</button>
                                    </form>
                                </div>
                            @endif
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
