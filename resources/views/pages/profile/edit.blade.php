@extends('layouts.master')
@section('main')
    <div class="title">Profile</div>
    <div class="content-wrapper">
        <div class="row same-height">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Data Pribadi</h5>
                    <div class="card-body">
                        <form class="form-horizontal d-flex flex-column gap-3" action="{{ route('profile.update') }}"
                            method="post">
                            @csrf
                            @method('PATCH')
                            <div class="d-flex gap-3">
                                <div class="form-group flex-grow-1">
                                    <label class="mb-1 control-label" for="name">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}">
                                </div>
                                <div class="form-group flex-grow-1">
                                    <label class="mb-1 control-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}">
                                </div>
                            </div>
                            {{-- role readonly --}}
                            <div class="form-group">
                                <label class="mb-1 control-label" for="role">Role</label>
                                <input type="text" class="form-control text-uppercase" id="role" name="role"
                                    value="{{ $user->role }}" readonly>
                            </div>
                            @if ($user->role == 'guru')
                                <div class="form-group">
                                    <label class="mb-1 control-label" for="sekolah_id">Asal Sekolah</label>
                                    <input type="text" class="form-control" id="sekolah_id" name="sekolah_id"
                                        value="{{ $user->guru->sekolah->nama }}" readonly>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="form-group flex-grow-1">
                                        <label class="mb-1 control-label" for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip"
                                            value="{{ $user->guru->nip }}">
                                    </div>
                                    <div class="form-group flex-grow-1">
                                        <label class="mb-1 control-label" for="mata_pelajaran">Mata Pelajaran</label>
                                        <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran"
                                            value="{{ $user->guru->mata_pelajaran }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-1 control-label" for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $user->guru->alamat }}</textarea>
                                </div>
                            @elseif($user->role == 'siswa')
                                <div class="form-group">
                                    <label class="mb-1 control-label" for="sekolah_id">Asal Sekolah</label>
                                    <input type="text" class="form-control" id="sekolah_id" name="sekolah_id"
                                        value="{{ $user->siswa->sekolah->nama }}" readonly>
                                </div>
                                <div class="d-flex gap-3">
                                    <div class="form-group flex-grow-1">
                                        <label class="mb-1 control-label" for="nis">NIS</label>
                                        <input type="text" class="form-control" id="nis" name="nis"
                                            value="{{ $user->siswa->nis }}">
                                    </div>
                                    <div class="form-group flex-grow-1">
                                        <label class="mb-1 control-label" for="kelas">Kelas</label>
                                        <input type="text" class="form-control" id="kelas" name="kelas"
                                            value="{{ $user->siswa->kelas }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-1 control-label" for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $user->siswa->alamat }}</textarea>
                                </div>
                            @endif
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if ($user->role == 'admin')
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Data Sekolah</h5>
                        <div class="card-body">
                            <form class="form-horizontal d-flex flex-column gap-3"
                                action="{{ route('profile.updateSekolah') }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="d-flex gap-3">
                                    <div class="form-group flex-grow-1">
                                        <label class="mb-1 control-label" for="nama_sekolah">Nama Sekolah</label>
                                        <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah"
                                            value="{{ $user->admin->sekolah->nama }}">
                                    </div>
                                    <div class="form-group flex-grow-1">
                                        <label class="mb-1 control-label" for="npsn">NPSN</label>
                                        <input type="text" class="form-control" id="npsn" name="npsn"
                                            value="{{ $user->admin->sekolah->npsn }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mb-1 control-label" for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ $user->admin->sekolah->alamat }}</textarea>
                                </div>
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
