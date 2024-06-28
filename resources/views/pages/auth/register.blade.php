@extends('layouts.guest')
@section('content')
  <div class="col-lg-6 col-md-7 col-sm-8">
    <div class="card shadow-lg">
      <div class="card-body p-4">
        <h1 class="fs-4 text-center fw-bold mb-4">Register</h1>
        <h1 class="fs-6 mb-3">Daftar untuk mendapatkan manfaat lebih banyak!!</h1>
        <form method="POST" action="{{ route('register') }}" class="needs-validation">
          @csrf
          <div class="mb-3">
            <label class="mb-2 text-muted" for="name">Nama Lengkap</label>
            <div class="input-group input-group-join mb-3">
              <input type="text" placeholder="Masukkan Nama Anda" id="name" class="form-control" name="name"
                required autofocus autocomplete="name">
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-user"></i>&nbsp</span>
            </div>
          </div>
          <div class="mb-3">
            <label class="mb-2 text-muted" for="email">E-Mail Address</label>
            <div class="input-group input-group-join mb-3">
              <input id="email" type="email" placeholder="Masukkan Email" class="form-control" name="email"
                required autofocus autocomplete="username">
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-envelope"></i>&nbsp</span>
            </div>
          </div>

          <div class="mb-3">
            <div class="mb-2 w-100">
              <label class="text-muted" for="password">Password</label>
            </div>
            <div class="input-group input-group-join mb-3">
              <input type="password" class="form-control" id="password" placeholder="Password Anda" name="password"
                required>
              <span class="input-group-text rounded-end password cursor-pointer">
                &nbsp<i id="eye-1" class="fa fa-eye"></i>&nbsp
              </span>
            </div>
          </div>
          <div class="mb-3">
            <div class="mb-2 w-100">
              <label class="text-muted" for="password">Konfirmasi Password</label>
            </div>
            <div class="input-group input-group-join mb-3">
              <input type="password" class="form-control" id="password_confirmation"
                placeholder="Konfirmasi Password Anda" name="password_confirmation" required>
              <span class="input-group-text rounded-end password cursor-pointer">
                &nbsp
                <i id="eye-2" class="fa fa-eye"></i>&nbsp
              </span>
            </div>
          </div>

          <div class="mb-3">
            <label class="mb-2 text-muted" for="role">Role</label>
            <div class="input-group input-group-join mb-3">
              <select name="role" id="role" class="form-select" required>
                <option value="">Select Role</option>
                <option value="admin">Admin Sekolah</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
              </select>
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-user"></i>&nbsp</span>
            </div>
          </div>

          <div id="nis_input" class="mb-3 d-none">
            <label class="mb-2 text-muted" for="nis">NIS</label>
            <div class="input-group input-group-join mb-3">
              <input type="text" placeholder="Masukkan NIS" id="nis" class="form-control" name="nis">
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-id-card"></i>&nbsp</span>
            </div>
          </div>

          <div id="sekolah_input" class="mb-3">
            <label class="mb-2 text-muted" for="sekolah_id">Asal Sekolah</label>
            <div class="input-group input-group-join mb-3">
              <select name="sekolah_id" id="sekolah_id" class="form-select">
                <option value="">Pilih Asal Sekolah</option>
                @foreach ($dataSekolah as $sekolah)
                  <option value="{{ $sekolah->id }}">{{ $sekolah->nama }}</option>
                @endforeach
              </select>
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-school"></i>&nbsp</span>
            </div>
          </div>

          <div id="kelas_input" class="mb-3 d-none">
            <label class="mb-2 text-muted" for="kelas_id">Kelas</label>
            <div class="input-group input-group-join mb-3">
              <select name="kelas_id" id="kelas_id" class="form-select">
                <option value="">Pilih Kelas</option>
              </select>
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-school"></i>&nbsp</span>
            </div>
          </div>


          <div id="admin_form" class="d-flex flex-column gap-3 mb-3 d-none">
            <div>
              <label class="mb-2 text-muted" for="sekolah">Asal Sekolah</label>
              <div class="input-group input-group-join">
                <input type="text" placeholder="Masukkan Nama Sekolah" id="sekolah" class="form-control"
                  name="sekolah" autofocus>
                <span class="input-group-text rounded-end">&nbsp<i class="fa fa-school"></i>&nbsp</span>
              </div>
            </div>
          </div>

          <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary ms-auto">
              Register
            </button>
          </div>
        </form>
      </div>
      <div class="card-footer py-3 border-0">
        <div class="text-center">
          Sudah memiliki akun? <a href="{{ route('login') }}" class="text-dark">Login</a>
        </div>
      </div>
    </div>
    <div class="text-center mt-5 text-muted">
      Copyright &copy; 2024 &mdash; Selpu V.2
    </div>
  </div>
  <script>
    $(document).ready(function() {
      // Show or hide password
      const password = $('#password');
      const passwordConfirmation = $('#password_confirmation');
      $('#eye-1').click(function() {
        if (password.attr('type') === 'password') {
          password.attr('type', 'text');
          $('#eye-1').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          password.attr('type', 'password');
          $('#eye-1').removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });
      $('#eye-2').click(function() {
        if (passwordConfirmation.attr('type') === 'password') {
          passwordConfirmation.attr('type', 'text');
          $('#eye-2').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          passwordConfirmation.attr('type', 'password');
          $('#eye-2').removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });
      const role = $('#role');
      const adminForm = $('#admin_form');
      const sekolahInput = $('#sekolah_input');
      const kelasInput = $('#kelas_input');
      const nisInput = $('#nis_input');
      const kelasId = $('#kelas_id');
      const nisId = $('#nis');
      const sekolah = $('#sekolah');
      const idSekolah = $('#sekolah_id');
      role.change(function() {
        if (role.val() === 'admin') {
          adminForm.addClass('d-flex').removeClass('d-none');
          sekolahInput.addClass('d-none').removeClass('d-block');
          kelasInput.addClass('d-none').removeClass('d-block');
          nisInput.addClass('d-none').removeClass('d-block');
          sekolah.attr('required', true);
          nisId.attr('required', false);
        } else {
          if (role.val() === 'siswa') {
            kelasInput.addClass('d-block').removeClass('d-none');
            kelasId.attr('required', true);
            nisInput.addClass('d-block').removeClass('d-none');
            nisId.attr('required', true);
          } else {
            kelasInput.addClass('d-none').removeClass('d-block');
            nisInput.addClass('d-none').removeClass('d-block');
            kelasId.attr('required', false);
            nisId.attr('required', false);
          }
          adminForm.addClass('d-none').removeClass('d-flex');
          sekolahInput.addClass('d-block').removeClass('d-none');
          idSekolah.attr('required', true);
        }
      });
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
                kelasId.find('option').remove().end();
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
