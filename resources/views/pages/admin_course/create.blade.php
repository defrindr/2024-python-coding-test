@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('admin.course.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Ambil Course Baru</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Ambil Course</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('admin.course.store') }}"
              class="form-horizontal d-flex flex-column gap-3" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="course_id" class="mb-1 control-label">Course</label>
                <div class="col-sm-12">
                  <select class="form-select" id="course_id" name="course_id" required>
                    <option value="">Pilih Course</option>
                    @foreach ($courses as $item)
                      <option value="{{ $item->id }}" {{ old('course_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="guru_id" class="mb-1 control-label">Guru</label>
                <div class="col-sm-12">
                  <select class="form-select" id="guru_id" name="guru_id" required>
                    <option value="">Pilih Guru</option>
                    @foreach ($guru as $item)
                      <option value="{{ $item->id }}" {{ old('guru_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->user->name }}
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="d-flex flex-column gap-3" id="modul">
                <div class="row" id="modul-container[0]">
                  <div class="form-group col-10">
                    <label for="file[0]" class="mb-1 control-label">Upload Modul</label>
                    <div class="col-sm-12">
                      <input type="file" class="form-control" id="file[0]" name="file[0]">
                    </div>
                  </div>
                  <button type="button" class="btn btn-primary col-2 col-md-1 h-25 mt-auto" id="add-modul">
                    <i class="ti-plus"></i>
                  </button>
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
  <script>
    let i = 0;
    $('#add-modul').click(function() {
      i++;
      $('#modul').append(`
        <div class="row" id="modul-container[${i}]">
          <div class="form-group col-10">
            <label for="file[${i}]" class="mb-1 control-label">Upload Modul</label>
            <div class="col-sm-12">
              <input type="file" class="form-control" id="file[${i}]" name="file[${i}]">
            </div>
          </div>
          <button type="button" class="btn btn-warning col-2 col-md-1 h-25 mt-auto" id="remove-modul">
            <i class="ti-minus"></i>
          </button>
        </div>
      `);
    });
    $(document).on("click", "#remove-modul", function() {
      $(this).closest("div").remove();
    });
  </script>
@endsection