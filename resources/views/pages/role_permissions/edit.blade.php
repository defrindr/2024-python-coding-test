@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('permission.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Ubah Permission: {{ $role->name }}</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Ubah Permission {{ $role->name }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('permission.update', $role->id) }}" class="form-horizontal d-flex flex-column gap-3"
              method="POST">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="name" class="mb-1 control-label">Nama Role</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $role->name }}"
                  readonly>
              </div>
              <div class="form-group">
                <label for="permissions" class="mb-1 control-label">Permission</label>
                {{-- checkbox --}}
                <div class="row">
                  @foreach ($permissions as $permission)
                    <div class="col-md-3">
                      <div class="form-check">
                        <input type="checkbox" name="permissions[]" id="permission{{ $permission->id }}"
                          value="{{ $permission->id }}" class="form-check-input"
                          {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                        <label for="permission{{ $permission->id }}" class="form-check-label">
                          {{ $permission->name }}
                        </label>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
