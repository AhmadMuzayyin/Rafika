@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [ARSIP LAPORAN RFK]</h1>
                            {{-- @dd($item) --}}
                            <form>
                                @csrf
                                <div class="row">
                                    <div class="col-md col-sm col-lg">
                                        <select class="custom-select form-control" id="skpd" name="skpd">
                                            @foreach ($opd as $user)
                                                <option value="{{ $user->id }}"
                                                    {{ request()->get('skpd') == $user->id ? 'selected' : '' }}>
                                                    {{ $user->nama_skpd }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <select class="custom-select form-control" id="dana" name="dana">
                                            @foreach ($dana as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id != 1 ? ($item->id == $selected ? 'selected' : '') : 'selected' }}>
                                                    {{ $item->nama_sumber_dana }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>BULAN</th>
                                            <th>COVER</th>
                                            <th>JADWAL</th>
                                            <th>RFK</th>
                                            <th>GRAFIK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data != '')
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->nama_bulan }}</td>
                                                    <td>
                                                        <form action="{{ url('/admin/arsip/print/cover') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="dana"
                                                                value="{{ request()->get('dana') ? request()->get('dana') : 1 }}">
                                                            <input type="hidden" name="skpd"
                                                                value="{{ request()->get('skpd') ? request()->get('skpd') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">COVER</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ url('/admin/arsip/print/jadwal') }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="dana"
                                                                value="{{ request()->get('dana') ? request()->get('dana') : 1 }}">
                                                            <input type="hidden" name="skpd"
                                                                value="{{ request()->get('skpd') ? request()->get('skpd') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">JADWAL</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ url('/admin/arsip/print/rfk') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="dana"
                                                                value="{{ request()->get('dana') ? request()->get('dana') : 1 }}">
                                                            <input type="hidden" name="skpd"
                                                                value="{{ request()->get('skpd') ? request()->get('skpd') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">RFK</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ url('/admin/arsip/print/grafik') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item->id }}">
                                                            <input type="hidden" name="dana"
                                                                value="{{ request()->get('dana') ? request()->get('dana') : 1 }}">
                                                            <input type="hidden" name="skpd"
                                                                value="{{ request()->get('skpd') ? request()->get('skpd') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">GRAFIK</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
            $("#dana").change(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var dana = $(this).children("option:selected").val();
                var skpd = $("#skpd option:selected").val();
                window.location.href = '{{ url('/admin/arsip/rfk') }}?dana=' + dana + '&skpd=' + skpd
            });
        });
        $(document).ready(function() {
            $("#skpd").change(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var dana = $(this).children("option:selected").val();
                var skpd = $("#skpd option:selected").val();
                window.location.href = '{{ url('/admin/arsip/rfk') }}?dana=' + dana + '&skpd=' + skpd
            });
        });
    </script>
@endpush
