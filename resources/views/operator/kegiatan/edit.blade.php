@extends('template.main')
@section('content')
    <div ui-view class="app-body" id="view">
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <a href="{{ url('/operator/subkegiatan') }}"
                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                role="button">View</a>
                        </div>
                        <div class="box-body">
                            <h5>Form Edit Sub Kegiatan</h5>
                            {{-- <form id="updateActivity" action="{{ url('/operator/subkegiatan') }}" method="POST"> --}}
                            @foreach ($data as $item)
                                <form action="{{ url('/operator/subkegiatan/update') . '/' . $item->id }}"
                                    method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md -col-sm col-lg">
                                            <label for="rekening">NOMOR REKENING</label>
                                            <small class="text-danger">Mohon diisi dengan lengkap dan benar</small>
                                            <input type="text" class="form-control" id="rekening" name="rekening"
                                                placeholder="Contoh: 4.01.03.20.2.05.01" required autofocus
                                                value="{{ $item->rekening }}">
                                        </div>
                                        <div class="col-md -col-sm col-lg">
                                            <label for="sumberdana">SUMBER DANA</label>
                                            <select class="form-control" id="sumberdana" name="sumberdana" required>
                                                <option value="">---PILIH SUMBER DANA---</option>
                                                @foreach ($dana as $s)
                                                    <option value="{{ $s->id }}"
                                                        {{ $item->sumber_dana_id == $s->id ? 'selected' : '' }}>
                                                        {{ $s->nama_sumber_dana }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="subkegiatan">NAMA SUB KEGIATAN</label>
                                            <input type="text" class="form-control" name="subkegiatan" required
                                                value="{{ $item->nama_sub_kegiatan }}">
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="pengadaan">JENIS PENGADAAN</label>
                                            <select class="form-control" name="pengadaan" id="pengadaan" onchange="select()"
                                                required>
                                                <option value="">---PILIH JENIS PENGADAAN---</option>
                                                @foreach ($pengadaan as $pp)
                                                    <option value="{{ $pp->id }}"
                                                        {{ $item->pengadaan_id == $pp->id ? 'selected' : '' }}>
                                                        {{ $pp->nama_pengadaan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="anggaran">ANGGARAN</label>
                                            <small class="text-info">Ditulis tanpa titik dan koma</small>
                                            @foreach ($item->anggaran as $ag)
                                                @if ($ag->pelaksanaan == session()->get('pelaksanaan') && $ag->sub_kegiatan_id == $item->id)
                                                <input type="text" class="form-control" name="anggaran" required
                                                    value="{{ $ag->nominal_anggaran }}">
                                                    <input type="hidden" name="ag_id" value="{{ $ag->id }}">
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="pelaksanaan">METODE PELAKSANAAN</label>
                                            <select class="form-control" name="pelaksanaan" id="pelaksanaan" required>
                                                <option value="">---PILIH METODE PELAKSANAAN---</option>
                                                @foreach ($pelaksanaan as $pl)
                                                    <option value="{{ $pl->id }}"
                                                        {{ $item->pelaksanaan_id == $pl->id ? 'selected' : '' }}>
                                                        {{ $pl->nama_pelaksanaan }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <label for="bentukkegiatan">BENTUK KEGIATAN</label>
                                            <input type="text" class="form-control" name="bentukkegiatan" required
                                                value="{{ $item->bentuk_kegiatan }}">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="laporan">LAPORAN</label>
                                                    <div class="lpError"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input laporancheck" type="checkbox"
                                                                id="dau" name="laporan[]" value="dau"
                                                                {{ $item->dau == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="dau">
                                                                DAU
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input laporancheck" type="checkbox"
                                                                id="dak" name="laporan[]" value="dak"
                                                                {{ $item->dak == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="dak">
                                                                DAK
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input laporancheck" type="checkbox"
                                                                id="dbhc" name="laporan[]" value="dbhc"
                                                                {{ $item->dbhc == '1' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="dbhc">
                                                                DBHC
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="program">PROGRAM BUPATI</label>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="program"
                                                                id="ya" value="Ya"
                                                                {{ $item->program_bupati == 'Ya' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="ya">
                                                                Ya
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="program"
                                                                id="tidak" value="Tidak"
                                                                {{ $item->program_bupati == 'Tidak' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="tidak">
                                                                Tidak
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button type="submit"
                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none updateActivity"
                                                role="button">PERBARUI</button>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    {{-- <script>
      $(document).ready(function() {
            $(".updateActivity").click(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var id = $("input[name='id']").val();
                var rek = $("input[name='rek']").val();
                var dana = document.getElementById("dana").value;
                var subkegiatan = $("input[name='subkegiatan']").val();
                var pengadaan = document.getElementById("pengadaan").value;
                var anggaran = $("input[name='anggaran']").val();
                var kondisi = $("input[name='kondisi']").val();
                var ag_id = $("input[name='ag_id']").val();
                var pelaksanaan = document.getElementById("pelaksanaan").value;
                var kegiatan = $("input[name='kegiatan']").val();
                var laporan = [];
                var program = $('form input[type=radio]:checked').val();
                var Url = $(this).parents('form').attr('action');
                $(':checkbox:checked').each(function(i) {
                    laporan[i] = $(this).val();
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('kegiatan.up') }}',
                    data: {
                        _token: _token,
                        id: id,
                        rek: rek,
                        dana: dana,
                        subkegiatan: subkegiatan,
                        pengadaan: pengadaan,
                        anggaran: anggaran,
                        kondisi: kondisi,
                        pelaksanaan: pelaksanaan,
                        kegiatan: kegiatan,
                        laporan: laporan,
                        program: program,
                        ag_id: ag_id
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            toastr.options = {
                                "progressBar": true
                            }
                            toastr.success("Data sub kegiatan berhasil diperbarui!", "Success");
                            window.setTimeout(function() {
                                window.location.href =
                                    '{{ route('activity.index') }}'
                            }, 3000);
                        } else {
                            toastr.options = {
                                "progressBar": true
                            }
                            toastr.error(data.error, "Error");
                        }
                    }
                });
            });
        });
    </script> --}}
@endpush
