<!-- Data -->
<div class="modal fade" id="showdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Penanggung Jawab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table" id="table-data">
                        <thead>
                            <tr>
                                <th scope="col">NO</th>
                                <th scope="col">NAMA</th>
                                <th scope="col">NIP</th>
                                <th scope="col">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_penanggung_jawab }}</td>
                                    <td>{{ $item->nip }}</td>
                                    <td>
                                        <button type="button" class="md-btn md-raised m-b-sm blue  editPPTKUSER"
                                            role="button" style="border: 0px" data-toggle="modal"
                                            data-target="#ModalEdit" data-id="{{ $item->id }}"
                                            data-nip="{{ $item->nip }}" data-nama="{{ $item->nama_penanggung_jawab }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form
                                            action="{{ url('/operator/jadwal/edit/userpptk/destroy') . '/' . $item->id }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="md-btn md-raised m-b-sm red deletePPTK"
                                                role="button" style="border: 0px">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
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
{{-- Edit --}}
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Data Penanggung Jawab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/operator/jadwal/edit/userpptk/update') }}">
                    @csrf
                    <input type="hidden" id="ID" name="id">
                    <div class="row">
                        <label for="NIP">NIP</label>
                        <input type="text" class="form-control" id="NIP" name="nip_penanggung_jawab" required>
                    </div>
                    <div class="row mt-3">
                        <label for="NAMA">NAMA LENGKAP</label>
                        <input type="text" class="form-control" id="NAMA" name="nama_penanggung_jawab" required>
                    </div>
                    <button type="submit" class="md-btn md-raised m-b-sm blue mt-3 SIMPAN" role="button"
                        style="border: 0px">SIMPAN</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script>
        $(document).ready(function(e) {
            $('.editPPTKUSER').click(function(e) {
                e.preventDefault();
                $('#ID').val($(this).data('id'));
                $('#NIP').val($(this).data('nip'));
                $('#NAMA').val($(this).data('nama'));
            });

            $(".SIMPAN").click(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var id = $("input[name='id']").val();
                var nip = $("input[name='nip_penanggung_jawab']").val();
                var nama = $("input[name='nama_penanggung_jawab']").val();
                var Url = $(this).parents('form').attr('action');
                $.ajax({
                    type: 'POST',
                    url: Url,
                    data: {
                        _token: _token,
                        id: id,
                        nip: nip,
                        nama: nama
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            toastr.options = {
                                "progressBar": true
                            }
                            toastr.success("Berhasil memperbarui data User PPTK!", "Success");
                            window.setTimeout(function() {
                                location.reload();
                            }, 3000);
                        } else {
                            toastr.options = {
                                "progressBar": true
                            }
                            toastr.error("Gagal memperbarui data PPTK!", "Error");
                            window.setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }
                    }
                });
            });
        });
    </script>
@endpush
