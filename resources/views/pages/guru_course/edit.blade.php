@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('guru.course.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Ubah Course {{ $sekolahCourse->course->name }}</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Ubah Course</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('guru.course.update', $sekolahCourse->id) }}"
              class="form-horizontal d-flex flex-column gap-3" enctype="multipart/form-data">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="course_id" class="mb-1 control-label">Course</label>
                <div class="col-sm-12">
                  <select class="form-select" id="course_id" name="course_id" required disabled>
                    <option value="{{ $sekolahCourse->course_id }}">
                      {{ $sekolahCourse->course->name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="guru_id" class="mb-1 control-label">Guru</label>
                <div class="col-sm-12">
                  <select class="form-select" id="guru_id" name="guru_id" required disabled>
                    <option value="{{ $sekolahCourse->guru_id }}">
                      {{ $sekolahCourse->guru->user->name }}
                    </option>
                  </select>
                </div>
              </div>

              <div class="d-flex flex-column gap-3" id="modul">
                @if ($sekolahCourse->modul->isEmpty())
                  <div class="row" id="modul-container[0]">
                    <div class="form-group col-10">
                      <label for="file[0]" class="mb-1 control-label">Upload Modul</label>
                      <div class="col-sm-12">
                        <input type="file" class="form-control" id="file[0]" name="file[0]">
                      </div>
                    </div>
                    <button type="button" class="btn btn-primary col-1 h-25 mt-auto" id="add-modul">
                      <i class="ti-plus"></i>
                    </button>
                  </div>
                @endif
                @foreach ($sekolahCourse->modul as $index => $modul)
                  <div class="row" id="modul-container[{{ $index }}]">
                    <div class="form-group col-10">
                      @if ($modul->file_path)
                        <label for="file{{ $index }}" class="mb-1 control-label">Modul
                          {{ $modul->nama }}</label>
                      @else
                        <label for="file[{{ $index }}]" class="mb-1 control-label">Upload Modul</label>
                      @endif
                      <div class="col-sm-12">
                        @if ($modul->file_path)
                          <div class="d-flex align-items-center flex-column flex-md-row gap-2">
                            <a href="{{ route('modul.download', $modul->id) }}" class="btn btn-primary col-12 col-md-2">
                              Download
                            </a>
                            <input type="file" class="form-control" id="file{{ $index }}"
                              name="file{{ $index }}">
                            <input type="hidden" name="modul_id[{{ $index }}]" value="{{ $modul->id }}">
                            <button type="button" class="btn btn-info col-md-1 col-12 update-modul">
                              <i class="ti-save"></i>
                            </button>
                            <button type="button" class="btn btn-danger col-md-1 col-12 delete-modul">
                              <i class="ti-trash"></i>
                            </button>
                          </div>
                        @else
                          <input type="file" class="form-control" id="file[{{ $index }}]"
                            name="file[{{ $index }}]">
                        @endif
                      </div>
                    </div>
                    @if ($loop->last)
                      <button type="button" class="btn btn-primary col-2 col-md-1 h-25 mt-auto" id="add-modul">
                        <i class="ti-plus"></i>
                      </button>
                    @endif
                  </div>
                @endforeach
              </div>

              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">
                  Update
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    let i = 0;
    $('#add-modul').click(function() {
      i++;
      $('#modul').append(`
        <div class="row" id="modul-container[${i}]">
          <div class="form-group col-9">
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
    $(document).on("click", ".update-modul", function() {
      let modulId = $(this).prev().val();
      let file = $(this).prev().prev().get(0).files[0];
      if (file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PATCH');
        $.ajax({
          url: `/modul/${modulId}`,
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Modul berhasil diupdate',
              showConfirmButton: false,
              timer: 1500,
            }).then(() => {
              window.location.reload();
            });
          },
          error: function(xhr) {
            console.log(xhr);
          }
        });
      }
    });
    $(document).on("click", ".delete-modul", function() {
      let modulId = $(this).prev().prev().val();
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          const formData = new FormData();
          formData.append('_token', '{{ csrf_token() }}');
          formData.append('_method', 'DELETE');
          $.ajax({
            url: `/modul/${modulId}`,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
              Swal.fire({
                icon: 'success',
                title: 'Modul berhasil dihapus',
                showConfirmButton: false,
                timer: 1500,
              }).then(() => {
                window.location.reload();
              });
            },
            error: function(xhr) {
              console.log(xhr);
              Swal.fire({
                icon: 'error',
                title: xhr.responseJSON.message,
                showConfirmButton: false,
                timer: 1500,
              });
            }
          });
        }
      });
    });
  </script>
@endsection