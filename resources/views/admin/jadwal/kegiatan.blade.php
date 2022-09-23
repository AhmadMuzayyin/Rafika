<div class="row">
    <div class="col-md col-sm col-lg">
        <label for="kegiatan">INPUT PERSENTASE TARGET KEGIATAN</label>
        <div class="progress">
            <div class="ppp progress-bar progress-bar-striped progress-bar-animated" id="kegiatan" role="progressbar"
                aria-valuenow="{{ $progres ?? $progres }}" aria-valuemin="0"
                aria-valuemax="100" style="width: {{ $progres ?? $progres }}%">
                {{ $progres ?? $progres }}%
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row mt-2">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <label for="januari">JANUARI</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="januari"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ? '' : $jadwal[0]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="februari">FEBRUARI</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="februari"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ? '' : $jadwal[1]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="maret">MARET</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="maret"
                                name="kegiatan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[2]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="april">APRIL</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="april"
                                name="kegiatan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[3]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="mei">MEI</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="mei"
                                name="kegiatan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[4]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="juni">JUNI</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="juni"
                                name="kegiatan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[5]->target_kegiatan }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="juli">JULI</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="juli"
                                name="kegiatan[]" required value="{{ $jadwal->isEmpty() ? '' : $jadwal[6]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="agustus">AGUSTUS</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="agustus"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ? '' : $jadwal[7]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="september">SEPTEMBER</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="september"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ? '' : $jadwal[8]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="oktober">OKTOBER</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="oktober"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ? '' : $jadwal[9]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="november">NOVEMBER</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="november"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ?  '' : $jadwal[10]->target_kegiatan }}">
                        </div>
                        <div class="col">
                            <label for="desember">DESEMBER</label>
                            <input type="number" class="form-control input-bulan" style="font-size: 90%" id="desember"
                                name="kegiatan[]" required
                                value="{{ $jadwal->isEmpty() ? '' : $jadwal[11]->target_kegiatan }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
