@extends('admin.layouts.app')
@section('title','Admin Dashboard - '.config('app.name'))

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

  <div class="row">
    {{-- Pengajuan Baru (menunggu konfirmasi) --}}
    <div class="col-md-4 mb-4">
      <a href="{{ route('admin.internships.index', ['status' => 'waiting_confirmation']) }}" class="text-decoration-none">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pengajuan Baru</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['waiting'] }}</div>
          </div>
        </div>
      </a>
    </div>

    {{-- Disetujui --}}
    <div class="col-md-4 mb-4">
      <a href="{{ route('admin.internships.index', ['status' => 'confirmed']) }}" class="text-decoration-none">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['approved'] }}</div>
          </div>
        </div>
      </a>
    </div>

    {{-- Aktif (sementara = confirmed; nanti bisa dihitung by start_date/end_date) --}}
    <div class="col-md-4 mb-4">
      <a href="{{ route('admin.internships.index', ['status' => 'confirmed']) }}" class="text-decoration-none">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Aktif</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['active'] }}</div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <div class="row">
    {{-- Quick links --}}
    <div class="col-md-6 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Pengguna</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['users'] }} terdaftar</div>
          </div>
          <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">Lihat</a>
        </div>
      </div>
    </div>
    <div class="col-md-6 mb-4">
      <div class="card shadow h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Pengajuan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $counts['all_internships'] }} total</div>
          </div>
          <a href="{{ route('admin.internships.index') }}" class="btn btn-outline-secondary btn-sm">Lihat</a>
        </div>
      </div>
    </div>
  </div>
@endsection
