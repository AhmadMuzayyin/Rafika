@extends('template.main')

@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-header">
                                <a href="{{ url('/admin/users') }}" class="md-btn md-raised m-b-sm w-xs blue"
                                    role="button">View</a>
                            </div>
                        </div>
                        <div class="box-body">
                            <form action="{{ url('/admin/user/update') . '/' . $data->id }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="row mb-3">
                                    <div class="col-md col-sm col-lg">
                                        <label for="kode_skpd">KODE SKPD</label>
                                        <select class="form-control" id="kode_skpd" name="kode_skpd">
                                            <option value="">Pilih Kode SKPD</option>
                                            <option value="1" {{ $data->kode_skpd == 1 ? 'selected' : '' }}>Sekretariat
                                                Daerah</option>
                                            <option value="2" {{ $data->kode_skpd == 2 ? 'selected' : '' }}>Dinas
                                            </option>
                                            <option value="3" {{ $data->kode_skpd == 3 ? 'selected' : '' }}>Badan
                                            </option>
                                            <option value="4" {{ $data->kode_skpd == 4 ? 'selected' : '' }}>Kantor
                                            </option>
                                            <option value="5" {{ $data->kode_skpd == 5 ? 'selected' : '' }}>Kecamatan
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="nama_skpd">NAMA SKPD</label>
                                        <input type="text" class="form-control" id="nama_skpd" name="nama_skpd"
                                            placeholder="NAMA SKPD" value="{{ $data->nama_skpd }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md col-sm col-lg">
                                        <label for="nomor_tlp_kantor">NOMOR TELEPON KANTOR</label>
                                        <input type="text" class="form-control" id="nomor_tlp_kantor"
                                            name="nomor_tlp_kantor" placeholder="NOMOR TELEPON KANTOR"
                                            value="{{ $data->nomor_tlp_kantor }}">
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="alamat_kantor">ALAMAT KANTOR</label>
                                        <input type="text" class="form-control" id="alamat_kantor" name="alamat_kantor"
                                            placeholder="ALAMAT KANTOR" value="{{ $data->alamat_kantor }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md col-sm col-lg">
                                        <label for="nama_operator">NAMA OPERATOR</label>
                                        <input type="text" class="form-control" id="nama_operator" name="nama_operator"
                                            placeholder="NAMA OPERATOR" value="{{ $data->nama_operator }}">
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="nomor_tlp_operator">NO TELEPON OPERATOR</label>
                                        <input type="text" class="form-control" id="nomor_tlp_operator"
                                            name="nomor_tlp_operator" placeholder="NO TELEPON OPERATOR"
                                            value="{{ $data->nomor_tlp_operator }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md col-sm col-lg">
                                        <label for="username">USERNAME</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            placeholder="USERNAME" value="{{ $data->username }}">
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="password">PASSWORD</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="PASSWORD">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md col-sm col-lg">
                                        <label for="nama_kpa">NAMA KPA</label>
                                        <input type="text" class="form-control" id="nama_kpa" name="nama_kpa"
                                            placeholder="NAMA KPA" value="{{ $data->nama_kpa }}">
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="level">LEVEL</label>
                                        <select class="form-control" id="level" name="level">
                                            <option value="">Pilih Level User
                                            </option>
                                            <option value="1" {{ $data->isAdmin == 1 ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="0" {{ $data->isAdmin == 0 ? 'selected' : '' }}>
                                                Operator
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="alamat">ALAMAT OPERATOR</label>
                                        <textarea class="form-control" id="alamat" name="alamat_operator" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md col-sm col-lg mt-3">
                                        <button type="submit" class="md-btn md-raised m-b-sm w-xs blue"
                                            role="button">UPDATE</button>
                                        <!-- <button type="button" class="md-btn md-raised m-b-sm w-xs orange" role="button">RESET</button> -->
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
