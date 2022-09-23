@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [LAPORAN]</h1>
                        </div>
                        <div class="box-body">
                            <div class="table-resnponsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>NO</th>
                                        <th>BULAN</th>
                                        <th>TANGGAL MELAPOR</th>
                                        <th>STATUS</th>
                                    </thead>
                                    <tbody>
                                        @if ($data)
                                            @foreach ($data as $key => $value)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ helper::BulanOfName($key) }}</td>
                                                    <td>
                                                        <?php
                                                        foreach ($value as $key => $val) {
                                                            $tgl = $val->updated_at;
                                                        }
                                                        ?>
                                                        {{ $tgl }}
                                                    </td>
                                                    <td>
                                                        @foreach ($value as $status)
                                                        @endforeach
                                                        @if ($status->status == 1)
                                                            <button class="btn btn-fw btn-sm primary">MELAPOR</button>
                                                        @else
                                                            <button class="btn btn-fw btn-sm danger">TIDAK MELAPOR</button>
                                                        @endif
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
            <!-- ############ PAGE END-->
        </div>
    </div>
@endsection
