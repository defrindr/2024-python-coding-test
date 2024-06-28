@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('admin.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Edit Admin</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Edit Admin</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.update', $admin->id) }}"
              class="form-horizontal d-flex flex-column gap-3">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="name" class="mb-1 control-label">Nama Admin</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama Admin"
                    value="{{ $admin->user->name }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="mb-1 control-label">Email</label>
                <div class="col-sm-12">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                    value="{{ $admin->user->email }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="mb-1 control-label">Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    value="{{ old('password') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="mb-1 control-label">Konfirmasi Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password"
                    placeholder="Konfirmasi Password" value="{{ old('password') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="sekolah_id" class="mb-1 control-label">Asal Sekolah</label>
                <div class="col-sm-12">
                  <select class="form-select" id="sekolah_id" name="sekolah_id" required>
                    <option value="">Pilih Asal Sekolah</option>
                    @foreach ($dataSekolah as $item)
                      <option value="{{ $item->id }}" {{ $admin->sekolah_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama }}
                      </option>
                    @endforeach
                  </select>
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
