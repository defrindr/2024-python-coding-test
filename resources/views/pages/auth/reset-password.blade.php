@extends('layouts.guest')
@section('content')
  <div class="col-lg-6 col-md-7 col-sm-8">
    <div class="card shadow-lg">
      <div class="card-body p-4">
        <h1 class="fs-4 text-center fw-bold mb-4">Reset Password</h1>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.store') }}" class="needs-validation">
          @csrf
          <input type="hidden" name="token" value="{{ $request->route('token') }}">
          <div class="mb-3">
            <label class="mb-2 text-muted" for="email">E-Mail Address</label>
            <div class="input-group input-group-join mb-3">
              <input readonly id="email" type="email" placeholder="Masukan Email" class="form-control"
                name="email" required autofocus autocomplete="username" value="{{ old('email', $request->email) }}" />
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-envelope"></i>&nbsp</span>
              <x-input-error :messages="$errors->get('email')" for="email" class="mt-2" />
            </div>
          </div>

          <div class="mb-3">
            <label class="mb-2 text-muted" for="name">Nama Lengkap</label>
            <div class="input-group input-group-join mb-3">
              <input readonly type="text" id="name" class="form-control" placeholder="Enter Your Name"
                name="name" required autocomplete="name" value="{{ old('name', $dataUser->name) }}" />
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-user"></i>&nbsp</span>
              <x-input-error :messages="$errors->get('name')" for="name" class="mt-2" />
            </div>
          </div>

          <div class="mb-3">
            <label class="mb-2 text-muted" for="role">Role</label>
            <div class="input-group input-group-join mb-3">
              <input readonly type="text" id="role" class="form-control" placeholder="Enter Your Name"
                name="name" required value="{{ old('role', $dataUser->role) }}" />
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-user"></i>&nbsp</span>
              <x-input-error :messages="$errors->get('role')" for="role" class="mt-2" />
            </div>
          </div>

          <div class="mb-3">
            <label class="mb-2 text-muted" for="password">Password</label>
            <div class="input-group input-group-join mb-3">
              <input type="password" id="password" class="form-control" placeholder="Your password" name="password"
                required autocomplete="current-password" />
              <span class="input-group-text rounded-end password cursor-pointer">
                &nbsp<i id="eye" class="fa fa-eye"></i>&nbsp
              </span>
              <x-input-error :messages="$errors->get('password')" for="password" class="mt-2" />
            </div>
          </div>

          <div class="mb-3">
            <label class="mb-2 text-muted" for="password_confirmation">Konfimasi Password</label>
            <div class="input-group input-group-join mb-3">
              <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm Your Password"
                name="password_confirmation" required autocomplete="current-password" />
              <span class="input-group-text rounded-end password cursor-pointer">
                &nbsp<i id="eye" class="fa fa-eye"></i>&nbsp
              </span>
              <x-input-error :messages="$errors->get('password_confirmation')" for="password_confirmation" class="mt-2" />
            </div>
          </div>

          <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary ms-auto">Reset Password</button>
          </div>
        </form>
      </div>
      <div class="card-footer py-3 border-0">
        <div class="text-center">
          Belum memiliki akun?
          <a href="{{ route('register') }}" class="text-dark">Register</a>
        </div>
      </div>
    </div>
    <div class="text-center mt-5 text-muted">
      Copyright &copy; 2022 &mdash; Mulai Dari Null
    </div>
  </div>
  <script>
    $(document).ready(function() {
      const password = $('#password');
      $('#eye').click(function() {
        if (password.attr('type') === 'password') {
          password.attr('type', 'text');
          $('#eye').removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          password.attr('type', 'password');
          $('#eye').removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });
    });
  </script>
@endsection
