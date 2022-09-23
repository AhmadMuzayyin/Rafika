<div class="page">
    <form id="formID" action="{{ url('/operator/jadwal/edit/target/store') .'/'.$data->id }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md col-sm col-lg">
                <label for="kegiatan">INPUT NOMINAL TARGET KEUANGAN</label>
                <label for="kegiatan">Anggaran: {{ number_format($anggaran->nominal_anggaran, 0) }}</label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="kegiatan" role="progressbar"
                        aria-valuenow="{{ $progres ?? $progres }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $progres ?? $progres }}%">
                        {{ $progres ?? $progres }}%
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mt-2">
                        <div class="col">
                            <div class="row">
                                <input type="hidden" name="anggaran" value="{{ $anggaran->nominal_anggaran }}">
                                <div class="col">
                                    <label for="januari">JANUARI</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[0]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[0]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="februari">FEBRUARI</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[1]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[1]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="marete">MARET</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[2]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[2]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="april">APRIL</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[3]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[3]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="mei">MEI</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[4]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[4]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="juni">JUNI</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[5]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[5]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="juli">JULI</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[6]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[6]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="agustus">AGUSTUS</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[7]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[7]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="september">SEPTEMBER</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[8]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[8]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="oktober">OKTOBER</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[9]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[9]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="november">NOVEMBER</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[10]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[10]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                                <div class="col">
                                    <label for="desember">DESEMBER</label>
                                    <input type="number" class="form-control" style="font-size: 85%"
                                        name="keuangan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[11]->target_keuangan }}" {{ $jadwal->isEmpty() ? '' : ($jadwal[11]->bulan_id <= date('n') ? 'readonly' : '') }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (session()->get('pelaksanaan') == 0)
            @include('operator.jadwal.kegiatan')
        @endif
        <div class="row mt-2">
            <div class="col">
                @if ($aktif->status == '1')
                    <button type="submit" class="md-btn md-raised m-b-sm blue" name="funcKU" value="1"
                        role="button">SIMPAN</button>
                    <button type="submit" class="md-btn md-raised m-b-sm warn" name="funcKU" value="0"
                        role="button">Update</button>
                @else
                    <div class="alert alert-danger" role="alert">
                        Inputan dinonaktifkan, silahkan hubungi admin!
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>
@push('script')
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
