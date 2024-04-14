@extends('layouts.guest')
@section('content')
  <div class="col-lg-6 col-md-7 col-sm-8">
    <div class="card shadow-lg">
      <div class="card-body p-4">
        <h1 class="fs-4 text-center fw-bold mb-4">Login</h1>
        <h1 class="fs-6 mb-3">Please enter your email and password to log in.</h1>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}" class="needs-validation">
          @csrf
          <div class="mb-3">
            <label class="mb-2 text-muted" for="email">E-Mail Address</label>
            <div class="input-group input-group-join mb-3">
              <input id="email" type="email" placeholder="Enter Email" class="form-control" name="email"
                required autofocus autocomplete="username" />
              <span class="input-group-text rounded-end">&nbsp<i class="fa fa-envelope"></i>&nbsp</span>
              <x-input-error :messages="$errors->get('email')" for="email" class="mt-2" />
            </div>
          </div>

          <div class="mb-3">
            <div class="mb-2 w-100">
              <label class="text-muted" for="password">Password</label>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="float-end"> Forgot Password? </a>
              @endif
            </div>
            <div class="input-group input-group-join mb-3">
              <input type="password" id="password" class="form-control" placeholder="Your password"
                name="password" required autocomplete="current-password" />
              <span class="input-group-text rounded-end password cursor-pointer">
                &nbsp<i id="eye" class="fa fa-eye"></i>&nbsp
              </span>
              <x-input-error :messages="$errors->get('password')" for="password" class="mt-2" />
            </div>
          </div>

          <div class="d-flex align-items-center">
            <div class="form-check">
              <input type="checkbox" name="remember_me" id="remember_me" class="form-check-input" />
              <label for="remember_me" class="form-check-label">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary ms-auto">Login</button>
          </div>
        </form>
      </div>
      <div class="card-footer py-3 border-0">
        <div class="text-center">
          Don't have an account yet?
          <a href="{{ route('register') }}" class="text-dark">Create an account</a>
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
