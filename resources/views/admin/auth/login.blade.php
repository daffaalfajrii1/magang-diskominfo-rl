@extends('admin.layouts.auth')
@section('title', 'Login Admin - '.config('app.name'))

@section('content')
<div class="row justify-content-center">
  <div class="col-xl-5 col-lg-6 col-md-8">

    <div class="text-center text-white mb-3">
      <div class="brand-badge mb-3">ADM</div>
      <h1 class="h4 mb-1 fw-bold">Login Admin</h1>
      <div class="small opacity-90">{{ config('app.name') }}</div>
    </div>

    <div class="card shadow-lg border-0">
      <div class="card-body p-5">

        @if ($errors->any())
          <div class="alert alert-danger mb-3">
            {{ $errors->first() }}
          </div>
        @endif

        @if (session('status'))
          <div class="alert alert-info mb-3">
            {{ session('status') }}
          </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="mb-3">
          @csrf
          <div class="form-group mb-3">
            <label class="small text-muted mb-1">Email Admin</label>
            <input type="email" name="email" class="form-control form-control-user" placeholder="nama@domain.go.id" required autofocus>
          </div>
          <div class="form-group mb-3">
            <div class="d-flex justify-content-between">
              <label class="small text-muted mb-1">Password</label>
              {{-- (opsional) tempat link lupa password admin nanti --}}
            </div>
            <input type="password" name="password" class="form-control form-control-user" placeholder="••••••••" required>
          </div>
          <div class="form-group mb-4">
            <div class="custom-control custom-checkbox small">
              <input type="checkbox" class="custom-control-input" id="remember" name="remember">
              <label class="custom-control-label" for="remember">Ingat saya</label>
            </div>
          </div>

          <button class="btn btn-primary btn-user btn-block">
            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
          </button>
        </form>

        <div class="text-center">
          <a class="small" href="{{ route('home') }}">← Kembali ke beranda</a>
        </div>

      </div>
    </div>

    <div class="text-center text-white-50 small mt-3">
      &copy; {{ date('Y') }} {{ config('app.name') }}
    </div>

  </div>
</div>
@endsection
