@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-6 col-md-8">
                    <div class="box">

                        <div class="box-header">
                            <h1>DATA [PAK]</h1>
                        </div>

                        <div class="box-body">
                            <button class="md-btn md-raised m-b-sm w-xs blue addPAK" id="addPAK"
                                role="button">TAMBAH</button>
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>TAHUN PAK</th>
                                            <th>TANGGAL</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $s)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $s->tahun_anggaran }}</td>
                                                <td>{{ $s->created_at }}</td>
                                                <td>

                                                    <form action="{{ url('/admin/pak/kunci') }}" method="POST"
                                                        class=" d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="sebelum"
                                                            value="{{ $s->kunci_pak[0]->id }}">
                                                        <div class="btn-group">
                                                            <button
                                                                class="md-btn md-raised m-b-sm {{ $s->kunci_pak[0]->status == 0 ? 'pink' : 'pink' }}">
                                                                <i
                                                                    class="bi {{ $s->kunci_pak[0]->status == 0 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <form action="{{ url('/admin/pak/kunci') }}" method="POST"
                                                        class=" d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="sesudah"
                                                            value="{{ $s->kunci_pak[1]->id }}">
                                                        <div class="btn-group">
                                                            <button
                                                                class="md-btn md-raised m-b-sm {{ $s->kunci_pak[1]->status == 0 ? 'indigo' : 'indigo' }}">
                                                                <i
                                                                    class="bi {{ $s->kunci_pak[1]->status == 0 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <form action="{{ url('/admin/pak/destroy', $s->id) }}"
                                                        class=" d-inline-block" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="btn-group">
                                                            <button type="submit" class="md-btn md-raised m-b-sm red deletePAK">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
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
                <div class="col-sm-6 col-md-4 pakhtml">

                </div>
                {{-- end col 2 --}}
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

        $('.addPAK').click(function() {
            var html = `
                    <div class="box pak_html" id="pak_html">
                        <div class="box-body">
                            <form action="{{ url('/admin/pak/store') }}" method="POST">
                                @csrf
                                  <div class="row">
                                      <div class="col">
                                            <label for="pakDate">Tahun PAK</label>
                                            <input type="text" class="form-control" id="pakDate" name="tahun_anggaran" autocomplete="off">
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col">
                                          <button type="submit" class="md-btn md-raised m-b-sm w-xs blue" role="button">SIMPAN</button>
                                          <button type="button" class="md-btn md-raised m-b-sm w-xs white" id="btl" role="button">BATAL</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                    </div>
                    `;

            $('.pakhtml').append(html);
            document.getElementById('addPAK').disabled = true;

            const year = new Date().getFullYear();
            $('#pakDate').yearpicker({
                startYear: year,
            });

            $('#btl').click(function() {
                $('#pak_html').remove()
                document.getElementById('addPAK').disabled = false;
            });
        });

    </script>
@endpush
