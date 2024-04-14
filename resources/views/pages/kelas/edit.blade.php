@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    @if (Auth::user()->role == 'super_admin')
      <a href="{{ route('kelas.index') }}" class="text-decoration-none">
        <i class="ti-arrow-circle-left"></i>
      </a>
    @else
      <a href="{{ route('admin.kelas.index') }}" class="text-decoration-none">
        <i class="ti-arrow-circle-left"></i>
      </a>
    @endif
    <span class="ms-2">Tambah Kelas</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Tambah Kelas</h4>
          </div>
          <div class="card-body">
            <form method="POST"
              @if (Auth::user()->role == 'super_admin') action="{{ route('kelas.store') }}"
              @else action="{{ route('admin.kelas.store') }}" @endif
              class="form-horizontal d-flex flex-column gap-3">
              @csrf
              @method('PATCH')
              <div class="form-group">
                <label for="name" class="mb-1 control-label">Nama Kelas</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="nama_kelas" placeholder="Nama Kelas"
                    value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required />
                </div>
              </div>
              @if (Auth::user()->role == 'super_admin')
                <div class="form-group">
                  <label for="sekolah_id" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <select class="form-select" id="sekolah_id" name="sekolah_id" required>
                      <option value="">Pilih Asal Sekolah</option>
                      @foreach ($dataSekolah as $item)
                        <option value="{{ $item->id }}"
                          {{ old('sekolah_id', $kelas->sekolah_id) == $item->id ? 'selected' : '' }}>
                          {{ $item->nama }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @else
                {{-- text readonly current sekolah name and hidden sekolah id --}}
                <input type="hidden" name="sekolah_id" value="{{ Auth::user()->admin->sekolah_id }}">
                <div class="form-group">
                  <label for="sekolah" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="sekolah"
                      value="{{ Auth::user()->admin->sekolah->nama }}" readonly />
                  </div>
                </div>
              @endif

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
@endsection