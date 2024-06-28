@extends('layouts.master')
@section('main')
  <div class="title">Data Course</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Data Course yang telah diambil</h4>
            <a class="btn btn-info" href="{{ route('admin.course.create') }}">
              Ambil Course Baru
            </a>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Guru</th>
                  <th>Nama Course</th>
                  <th>Deskripsi</th>
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
  <script type="text/javascript">
    $(function() {
      /*------------------------------------------
      Render DataTable
      --------------------------------------------*/
      const table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.course.index') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
          },
          {
            data: 'guru.user.name',
            name: 'guru.user.name'
          },
          {
            data: 'course.name',
            name: 'course.name'
          },
          {
            data: 'course.description',
            name: 'course.description'
          },
          {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
          },
        ]
      });
    });
  </script>
@endsection
