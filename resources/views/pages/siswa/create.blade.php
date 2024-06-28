@extends('layouts.master')
@section('main')
  <div class="title d-flex align-items-center">
    <a href="{{ route('siswa.index') }}" class="text-decoration-none">
      <i class="ti-arrow-circle-left"></i>
    </a>
    <span class="ms-2">Tambah Siswa</span>
  </div>
  <div class="content-wrapper">
    <div class="row same-height">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Form Tambah Siswa</h4>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('siswa.store') }}" class="form-horizontal d-flex flex-column gap-3">
              @csrf
              <div class="form-group">
                <label for="name" class="mb-1 control-label">Nama Siswa</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="name" name="name" placeholder="Nama Siswa"
                    value="{{ old('name') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="nip" class="mb-1 control-label">NIS</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="nis" name="nis" placeholder="NIS"
                    value="{{ old('nis') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="email" class="mb-1 control-label">Email</label>
                <div class="col-sm-12">
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                    value="{{ old('email') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="password" class="mb-1 control-label">Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                    value="{{ old('password') }}" required />
                </div>
              </div>

              <div class="form-group">
                <label for="password_confirmation" class="mb-1 control-label">Konfirmasi Password</label>
                <div class="col-sm-12">
                  <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Konfirmasi Password" value="{{ old('password_confirmation') }}" required />
                </div>
              </div>

              @if (Auth::user()->role == 'super_admin')
                <div class="form-group">
                  <label for="sekolah_id" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <select class="form-select" id="sekolah_id" name="sekolah_id" required>
                      <option value="">Pilih Asal Sekolah</option>
                      @foreach ($dataSekolah as $item)
                        <option value="{{ $item->id }}" {{ old('sekolah_id') == $item->id ? 'selected' : '' }}>
                          {{ $item->nama }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @elseif(Auth::user()->role == 'admin')
                {{-- text readonly current sekolah name and hidden sekolah id --}}
                <input type="hidden" name="sekolah_id" value="{{ Auth::user()->admin->sekolah_id }}">
                <div class="form-group">
                  <label for="sekolah" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="sekolah"
                      value="{{ Auth::user()->admin->sekolah->nama }}" readonly />
                  </div>
                </div>
              @elseif(Auth::user()->role == 'guru')
                {{-- text readonly current sekolah name and hidden sekolah id --}}
                <input type="hidden" name="sekolah_id" value="{{ Auth::user()->guru->sekolah_id }}">
                <div class="form-group">
                  <label for="sekolah" class="mb-1 control-label">Asal Sekolah</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control" id="sekolah"
                      value="{{ Auth::user()->guru->sekolah->nama }}" readonly />
                  </div>
                </div>
              @endif

              @if (Auth::user()->role == 'super_admin')
                <div class="form-group">
                  <label for="kelas_id" class="mb-1 control-label">Kelas</label>
                  <div class="col-sm-12">
                    <select class="form-select" id="kelas_id" name="kelas_id" required>
                      <option value="">Pilih Kelas</option>
                    </select>
                  </div>
                </div>
              @else
                <div class="form-group">
                  <label for="kelas_id" class="mb-1 control-label">Kelas</label>
                  <div class="col-sm-12">
                    <select class="form-select" id="kelas_id" name="kelas_id" required>
                      <option value="">Pilih Kelas</option>
                      @foreach ($dataKelas as $item)
                        <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>
                          {{ $item->nama_kelas }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              @endif

              <div class="form-group">
                <label for="alamat" class="mb-1 control-label">Alamat</label>
                <div class="col-sm-12">
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat" required>{{ old('alamat') }}</textarea>
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
    $(document).ready(function() {
      const idSekolah = $('#sekolah_id');
      const kelasId = $('#kelas_id');
      $('#sekolah_id').change(function() {
        if (idSekolah.val() !== '') {
          $.ajax({
            url: `{{ route('kelas.getBySekolah') }}`,
            type: 'POST',
            data: {
              _token: '{{ csrf_token() }}',
              sekolah_id: idSekolah.val()
            },
            success: function(data) {
              if (data.length > 0) {
                $.each(data, function(index, kelas) {
                  kelasId.append('<option value="' + kelas.id + '">' + kelas.nama_kelas +
                    '</option>');
                });
              } else {
                kelasId.find('option').remove().end();
                kelasId.append('<option value="">Tidak ada data kelas</option>');
              }
            },
            error: function(err) {
              console.log(err);
            }
          });
        }
      });
    });
  </script>
@endsection
