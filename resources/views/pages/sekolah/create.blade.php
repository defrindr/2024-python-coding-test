@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('sekolah.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Tambah Sekolah</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Tambah Sekolah</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('sekolah.store') }}"
              class="form-horizontal d-flex flex-column gap-3">
              @csrf
              <div class="form-group">
                <label for="nama" class="mb-1 control-label">Nama Sekolah</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nama" name="nama"
                    placeholder="Nama Sekolah" value="{{ old('nama') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="npsn" class="mb-1 control-label">NPSN</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="npsn" name="npsn" placeholder="NPSN"
                    value="{{ old('npsn') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="alamat" class="mb-1 control-label">Alamat</label>
                <div class="col-sm-12">
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>{{ old('alamat') }}</textarea>
                </div>
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
    </div>
  </div>
@endsection
