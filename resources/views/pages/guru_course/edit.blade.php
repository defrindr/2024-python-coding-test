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

              <div class="form-group">
                <label for="pertemuan" class="mb-1 control-label">Pertemuan</label>
                <div class="col-sm-12">
                  <input type="number" class="form-control" min="0" id="pertemuan" name="pertemuan"
                    value="{{ $sekolahCourse->pertemuan }}" disabled>
                </div>
              </div>

              @foreach ($moduls as $modul)
                <div class="row gap-2" id="modul-container[{{ $loop->index }}]">
                  <div class="form-group">
                    <span class="mb-1 fw-bolder control-label">Modul Pertemuan {{ $loop->index + 1 }}</span>
                  </div>
                  @foreach ($modul as $file)
                    <div class="form-group">
                      @if ($file->file_path)
                        <label for="file[{{ $loop->parent->index }}][{{ $loop->index }}]"
                          class="mb-1 control-label">Modul {{ $file->nama }}</label>
                      @else
                        <label for="file[{{ $loop->parent->index }}][{{ $loop->index }}]"
                          class="mb-1 control-label">Modul {{ $loop->index + 1 }}</label>
                      @endif
                      <div class="col-sm-12">
                        <div class="d-flex align-items-center flex-column flex-md-row gap-2">
                          <a href="{{ route('modul.download', $file->id) }}" class="btn btn-primary col-12 col-md-2">
                            Download
                          </a>
                          <input type="file" class="form-control"
                            id="file[{{ $loop->parent->index }}][{{ $loop->index }}]"
                            name="file[{{ $loop->parent->index }}][{{ $loop->index }}]">
                          <input type="hidden" name="modul_id[{{ $loop->parent->index }}][{{ $loop->index }}]"
                            value="{{ $file->id }}">
                          <button type="button" class="btn btn-info col-md-1 col-12 update-modul">
                            <i class="ti-save"></i>
                          </button>
                          <button type="button" class="btn btn-danger col-md-1 col-12 delete-modul">
                            <i class="ti-trash"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endforeach
              <div class="d-flex flex-column gap-3" id="modul"></div>
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
    $(document).ready(function() {
      let i = 0;
      @if ($moduls->count() > 0)
        i = {{ $moduls->count() }}
        $('#pertemuan').attr('readonly', true);
      @endif
      let pertemuan = $('#pertemuan').val();
      if (pertemuan > 0) {
        $('#modul').removeClass('d-none');
        $('#modul').addClass('d-flex');
      }

      function updateModulFields() {
        $('#modul').empty();
        for (i; i < pertemuan; i++) {
          $('#modul').append(`
            <div class="row gap-2" id="modul-container[${i}]">
              <input type="hidden" name="pertemuan" value="${i+1}">
              <div class="form-group">
                <span class="mb-1 fw-bolder control-label">Modul Pertemuan ${i + 1}</span>
              </div>
              <div class="form-group col-9">
                <label for="file[${i}][0]" class="mb-1 control-label">Upload Modul 1</label>
                <div class="col-sm-12">
              <input type="file" class="form-control" id="file[${i}][0]" name="file[${i}][0]">
                </div>
              </div>
              <div class="form-group col-9">
                <label for="file[${i}][1]" class="mb-1 control-label">Upload Modul 2</label>
                <div class="col-sm-12">
              <input type="file" class="form-control" id="file[${i}][1]" name="file[${i}][1]">
                </div>
              </div>
              <div class="form-group col-9">
                <label for="file[${i}][2]" class="mb-1 control-label">Upload Modul 3</label>
                <div class="col-sm-12">
              <input type="file" class="form-control" id="file[${i}][2]" name="file[${i}][2]">
                </div>
              </div>

            </div>
          `);
        }
      }
      updateModulFields();

      $(document).on("change", "#pertemuan", function() {
        pertemuan = $(this).val();
        console.log(i);
        if (pertemuan > 0) {
          $('#modul').removeClass('d-none');
          $('#modul').addClass('d-flex');
        } else {
          $('#modul').addClass('d-none');
        }
        updateModulFields();
      });


      $(document).on("click", ".update-modul", function() {
        let modulId = $(this).prev().val();
        console.log(modulId);
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
    });
  </script>
@endsection
