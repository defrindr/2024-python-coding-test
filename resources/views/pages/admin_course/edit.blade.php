@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('admin.course.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Ubah Course yang telah diambil</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Ubah Course</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.course.update', $sekolahCourse->id) }}"
              class="form-horizontal d-flex flex-column gap-3">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="course_id" class="mb-1 control-label">Pilih Course</label>
                <div class="col-sm-12">
                  <select class="form-select" id="course_id" name="course_id" required>
                    <option value="">Pilih Course</option>
                    @foreach ($courses as $item)
                      <option value="{{ $item->id }}" {{ $sekolahCourse->course->id == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="guru_id" class="mb-1 control-label">Pilih Guru</label>
                <div class="col-sm-12">
                  <select class="form-select" id="guru_id" name="guru_id" required>
                    <option value="">Pilih Guru</option>
                    @foreach ($guru as $item)
                      <option value="{{ $item->id }}" {{ $sekolahCourse->guru->id == $item->id ? 'selected' : '' }}>
                        {{ $item->user->name }}
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