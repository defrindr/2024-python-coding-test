@extends('layouts.master')
@section('main')
  <div class="title">Permission</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Role dan Permission</h4>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($roles as $role)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                      <a href="{{ route('permission.edit', $role->id) }}" class="btn btn-primary">
                        Manage Permission
                      </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
