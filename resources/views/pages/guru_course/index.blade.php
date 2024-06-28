@extends('layouts.master')
@section('main')
  <div class="title">Data Course</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Data Course untuk guru {{ Auth::user()->name }}</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>No</th>
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
      const table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('guru.course.index') }}",
        columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
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
          }
        ]
      });
    });
  </script>
@endsection
