@extends('template.main')
@section('content')
    <div ui-view class="app-body" id="view">
        <div class="padding">
            <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        <a href="{{ url('/operator/subkegiatan') }}"
                            class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white" role="button">View</a>
                    </div>
                    <div class="box-body">
                        <h5>Form Entry</h5>
                        <form id="addActivity" action="{{ url('/operator/subkegiatan/store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="pak_id" value="{{ session()->get('pak_id') }}">
                            <div class="row">
                                <div class="col-md -col-sm col-lg">
                                    <label for="rekening">NOMOR REKENING</label>
                                    <small class="text-danger">Mohon diisi dengan lengkap dan benar</small>
                                    <input type="text" class="form-control @error('rekening') parsley-error @enderror"
                                        id="rekening" name="rekening" placeholder="Contoh: 4.01.03.20.2.05.01" required
                                        value="{{ @old('rekening') }}">
                                    @error('rekening')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="col-md -col-sm col-lg">
                                    <label for="sumberdana">SUMBER DANA</label>
                                    <select class="form-control @error('sumberdana') parsley-error @enderror"
                                        id="sumberdana" name="sumberdana" required>
                                        <option value="">---PILIH SUMBER DANA---</option>
                                        <option value="1" {{ @old('sumberdana') == '1' ? 'selected' : '' }}>APBD
                                            Kabupaten
                                            Pamekasan</option>
                                        <option value="2" {{ @old('sumberdana') == '2' ? 'selected' : '' }}>APBD Provinsi</option>
                                        <option value="3" {{ @old('sumberdana') == '3' ? 'selected' : '' }}>APBN</option>
                                    </select>
                                    @error('sumberdana')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="subkegiatan">NAMA SUB KEGIATAN</label>
                                    <input type="text" class="form-control" name="subkegiatan" required
                                        value="{{ @old('subkegiatan') }}">
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="pengadaan">JENIS PENGADAAN</label>
                                    <select class="form-control @error('pengadaan') parsley-error @enderror"
                                        name="pengadaan" id="pengadaan" onchange="select()" required>
                                        <option value="">---PILIH JENIS PENGADAAN---</option>
                                        <option value="1" {{ @old('pengadaan') == '1' ? 'selected' : '' }}>Konstruksi</option>
                                        <option value="2" {{ @old('pengadaan') == '2' ? 'selected' : '' }}>Barang</option>
                                        <option value="3" {{ @old('pengadaan') == '3' ? 'selected' : '' }}>Konsultansi</option>
                                        <option value="4" {{ @old('pengadaan') == '4' ? 'selected' : '' }}>Jasa Lainnya</option>
                                    </select>
                                    @error('pengadaan')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="anggaran">ANGGARAN</label>
                                    <small class="text-info">Ditulis tanpa titik dan koma</small>
                                    <input type="text" class="form-control @error('anggaran') parsley-error @enderror"
                                        name="anggaran" required value="{{ @old('anggaran') }}">
                                    <input type="hidden" name="kondisi" value="{{ session()->get('pelaksanaan') }}">
                                    @error('anggaran')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="pelaksanaan">METODE PELAKSANAAN</label>
                                    <select class="form-control @error('pelaksanaan') parsley-error @enderror"
                                        name="pelaksanaan" id="pelaksanaan" required>
                                        <option value="">---PILIH METODE PELAKSANAAN---</option>
                                        <option id="opt" value="1" {{ @old('pelaksanaan') == '1' ? 'selected' : '' }}>Tender</option>
                                        <option value="2" {{ @old('pelaksanaan') == '2' ? 'selected' : '' }}>Penunjukan Langsung</option>
                                        <option value="3" {{ @old('pelaksanaan') == '3' ? 'selected' : '' }}>Pengadaan Langsung</option>
                                        <option value="4" {{ @old('pelaksanaan') == '4' ? 'selected' : '' }}>ePurchasing</option>
                                        <option value="5" {{ @old('pelaksanaan') == '5' ? 'selected' : '' }}>Swakelola</option>
                                    </select>
                                    @error('pelaksanaan')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="bentukkegiatan">BENTUK KEGIATAN</label>
                                    <input type="text"
                                        class="form-control @error('bentukkegiatan') parsley-error @enderror"
                                        name="bentukkegiatan" required value="{{ @old('bentukkegiatan') }}">
                                    @error('bentukkegiatan')
                                        <ul class="parsley-errors-list filled">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
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
                                                    <input class="form-check-input" type="checkbox" id="dau"
                                                        name="laporan[]" value="dau">
                                                    <label class="form-check-label" for="dau">
                                                        DAU
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dak"
                                                        name="laporan[]" value="dak">
                                                    <label class="form-check-label" for="dak">
                                                        DAK
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="dbhc"
                                                        name="laporan[]" value="dbhc">
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
                                            <label for="programbupati">PROGRAM PRIORITAS BUPATI</label>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="programbupati"
                                                        id="gridRadios1" value="Ya" checked>
                                                    <label class="form-check-label" for="gridRadios1">
                                                        Ya
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="programbupati"
                                                        id="gridRadios1" value="Tidak" checked>
                                                    <label class="form-check-label" for="gridRadios1">
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
                                    <button type="submit" class="md-btn md-raised m-b-sm w-xs blue text-decoration-none"
                                        role="button">SIMPAN</button>
                                    <button type="reset"
                                        class="md-btn md-raised m-b-sm w-xs orange text-decoration-none text-white"
                                        role="button">RESET</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
<script>
    $(document).ready(function() {
        $("#addActivity").validate({
            messages: {
                "laporan[]": "Harap pilih min 1 laporan!"
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                let lp = document.getElementsByClassName("lpError");

                if (element.prop("type") === "checkbox") {
                    error.append(lp);
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });
    });

    function select() {
        var select = document.getElementById('pengadaan');
        var option = select.options[select.selectedIndex];
        if (option.value == "3") {
            $('#opt').replaceWith(`<option value="6" >
                                       Seleksi
                                  </option>`);
        }
    }
    select();
</script>
