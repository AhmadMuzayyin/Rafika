<div class="page">
    <div class="row">
        <div class="col">
            <button type="button" class="md-btn md-raised m-b-sm blue" role="button" data-toggle="modal"
                data-target="#exampleModal">
                <i class="bi bi-plus-circle"></i> TAMBAH
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th scope="col">NO</th>
                    <th scope="col">LOKASI</th>
                    <th scope="col">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lokasi as $l)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $l->alamat }}</td>
                        <td>
                            <form action="{{ url('/operator/jadwal/edit/lokasi/destroy') . '/' . $l->id }}">
                                @csrf
                                <button type="button" class="md-btn md-raised m-b-sm red deleteLokasi" role="button"
                                    style="border: 0px">
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


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Input Lokasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                @csrf
                <input type="hidden" name="sub_kegiatan_id" value="{{ $data->id }}">
                <div class="modal-body">
                    <label for="lokasi">PILIH LOKASI</label>
                    <input type="text" class="form-control" id="lokasi" name="lokasi">
                </div>
                <div class="modal-footer">
                    <button type="button" class="md-btn md-raised m-b-sm white" role="button"
                        data-dismiss="modal">BATAL</button>
                    <button type="submit" class="md-btn md-raised m-b-sm blue kirim" role="button">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ ENV('MAP_KEY') }}"></script>
    <script>
        var searchInput = 'lokasi';

        $(document).ready(function() {
            var autocomplete;
            autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
                types: ['geocode'],
                componentRestrictions: {
                    country: "ID"
                }
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                const place = autocomplete.getPlace();
                const latt = place.geometry.location.lat();
                const long = place.geometry.location.lng();
                const kcmt = place.address_components.find((items) => items.types[0] == 'administrative_area_level_3');
                $('.kirim').click(function(e) {
                    e.preventDefault();
                    var _token = $("input[name='_token']").val();
                    var lokasi = $("input[name='lokasi']").val();
                    var sub_kegiatan_id = $("input[name='sub_kegiatan_id']").val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ url('/operator/jadwal/edit/lokasi/store') }}',
                        data: {
                            _token: _token,
                            lokasi: lokasi,
                            latt: latt,
                            long: long,
                            kecamatan: kcmt.long_name,
                            sub_kegiatan_id: sub_kegiatan_id
                        },
                        success: function(data) {
                            if ($.isEmptyObject(data.error)) {
                                location.reload();
                            } else {
                                toastr.options = {
                                    "progressBar": true
                                }
                                toastr.error("Gagal menambah data lokasi!", "error");
                                window.setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            }
                        }
                    });
                })
            });
        });

        $(document).ready(function() {
            $(".deleteLokasi").click(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var Url = $(this).parents('form').attr('action');
                $.ajax({
                    type: 'DELETE',
                    url: Url,
                    data: {
                        _token: _token
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            toastr.options = {
                                "progressBar": true
                            }
                            toastr.success("Data lokasi berhasil dihapus!", "Success");
                            window.setTimeout(function() {
                                location.reload();
                            }, 3000);
                        } else {
                            toastr.options = {
                                "progressBar": true
                            }
                            toastr.error("Gagal menghapus data lokasi!", "error");
                            window.setTimeout(function() {
                                location.reload();
                            }, 3000);
                        }
                    }
                });
            });
        });
    </script>

    <style>
        .pac-container {
            background-color: #FFF;
            z-index: 20;
            position: fixed;
            display: inline-block;
            float: left;
        }

        .modal {
            z-index: 20;
        }
        .app-header{
            z-index: 1;
        }

        .modal-backdrop {
            z-index: 10;
        }
    </style>
@endpush
