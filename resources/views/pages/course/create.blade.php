@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('course.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Tambah Course</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Tambah Course</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('course.store') }}" class="form-horizontal d-flex flex-column gap-3">
              @csrf
              <div class="form-group">
                <label for="name" class="mb-1 control-label">Nama Course</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama Course"
                    value="{{ old('name') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="description" class="mb-1 control-label">Deskripsi</label>
                <div class="col-sm-12">
                  <textarea class="form-control" id="description" name="description" placeholder="Deskripsi" required>{{ old('description') }}</textarea>
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
