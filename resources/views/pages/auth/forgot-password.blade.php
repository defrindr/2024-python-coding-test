@extends('layouts.guest')
@section('content')
  <div class="col-lg-6 col-md-7 col-sm-8">
    <div class="card shadow-lg">
      <div class="card-body p-4">
        <h1 class="fs-4 text-center fw-bold mb-4">Lupa Password</h1>
        <h1 class="fs-6 mb-3">
          Silahkan masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mereset password Anda.
        </h1>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('password.email') }}" class="needs-validation">
          @csrf
          <div class="mb-3">
            <label class="mb-2 text-muted" for="email">E-Mail Address</label>
            <div class="input-group input-group-join mb-3">
              <input id="email" type="email" placeholder="Masukkan Email" class="form-control" name="email"
                required autofocus autocomplete="username" />
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-envelope"></i>&nbsp</span>
              <x-input-error :messages="$errors->get('email')" for="email" class="mt-2" />
            </div>
          </div>

          <div class="d-flex align-items-center">
            <button type="submit" class="btn btn-primary ms-auto">Submit</button>
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
      Copyright &copy; 2022 &mdash; Mulai Dari Null
    </div>
  </div>
@endsection
