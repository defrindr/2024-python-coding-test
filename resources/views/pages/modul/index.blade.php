@extends('layouts.master')
@section('main')
  <div class="title">Modul Siswa</div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>List Data Modul Siswa</h4>
          </div>
          <div class="card-body table-responsive">
            {{-- <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th width="24px">No</th>
                  <th>Nama Guru</th>
                  <th>Nama Course</th>
                  <th>Deskripsi</th>
                  <th width="280px">Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table> --}}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
