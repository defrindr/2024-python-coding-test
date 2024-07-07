@extends('layouts.master')
@section('main')
<div class="title d-flex align-items-center">
  <a href="{{ route('siswa.course.index') }}" class="text-decoration-none">
    <i class="ti-arrow-circle-left"></i>
  </a>
  <span class="ms-2">Course {{ $sekolahCourse->course->name }} - {{ $sekolahCourse->sekolah->nama }}</span>
</div>
<div class="content-wrapper">
  <div class="row same-height">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex flex-column gap-3 table-responsive">
            <div class="form-group">
              <span class="fw-bold">Guru</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->guru->user->name }}</span>
              </div>
            </div>

            <div class="form-group">
              <span class="fw-bold">Course</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->course->name }}</span>
              </div>
            </div>

            <div class="form-group">
              <span class="fw-bold">Deskripsi</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->course->description }}</span>
              </div>
            </div>

            <div class="form-group">
              <span class="fw-bold">Pertemuan</span>
              <div class="col-sm-12 mt-1">
                <span>{{ $sekolahCourse->pertemuan }}</span>
              </div>
            </div>

            <div class="form-group">
              {!! $chart->container() !!}
            </div>

            @if($sekolahCourse->modul()->count() == 0)
              <div class="alert alert-warning">
                <div class="alert-body">
                Modul belum siap
                </div>
              </div>
            @endif
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th width="24px">No</th>
                  <th>Nama Modul</th>
                  <th width="280px">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script type="text/javascript">
  $(function () {
    const table = $('.data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('siswa.course.show', $sekolahCourse->id) }}",
      columns: [{
        data: 'DT_RowIndex',
        name: 'DT_RowIndex'
      },
      {
        data: 'nama',
        name: 'nama'
      },
      {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }
      ]
    });
  });
</script>
@endsection