@extends('admin.layouts.app')
@section('title','Admin Dashboard - '.config('app.name'))

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

  <div class="row">
    {{-- Pengajuan Baru --}}
    <div class="col-md-3 mb-4">
      @php $href = $newSubmissions > 0 ? route('admin.internships.index', ['status'=>'waiting_confirmation']) : null; @endphp
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body {{ $href ? 'p-0' : '' }}">
          @if($href)<a href="{{ $href }}" class="d-block p-3 text-decoration-none text-reset">@endif
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pengajuan Baru</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newSubmissions }}</div>
          @if($href)</a>@endif
        </div>
      </div>
    </div>

    {{-- Disetujui (active saja) --}}
    <div class="col-md-3 mb-4">
      @php $href = $approved > 0 ? route('admin.internships.index', ['status'=>'active']) : null; @endphp
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body {{ $href ? 'p-0' : '' }}">
          @if($href)<a href="{{ $href }}" class="d-block p-3 text-decoration-none text-reset">@endif
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $approved }}</div>
          @if($href)</a>@endif
        </div>
      </div>
    </div>

    {{-- Aktif --}}
    <div class="col-md-3 mb-4">
      @php $href = $active > 0 ? route('admin.internships.index', ['status'=>'active']) : null; @endphp
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body {{ $href ? 'p-0' : '' }}">
          @if($href)<a href="{{ $href }}" class="d-block p-3 text-decoration-none text-reset">@endif
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Aktif</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $active }}</div>
          @if($href)</a>@endif
        </div>
      </div>
    </div>

    {{-- Selesai --}}
    <div class="col-md-3 mb-4">
      @php $href = $completed > 0 ? route('admin.internships.index', ['status'=>'completed']) : null; @endphp
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body {{ $href ? 'p-0' : '' }}">
          @if($href)<a href="{{ $href }}" class="d-block p-3 text-decoration-none text-reset">@endif
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Selesai</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completed }}</div>
          @if($href)</a>@endif
        </div>
      </div>
    </div>
  </div>

  {{-- Baris metrik bawah --}}
  <div class="row">
    <div class="col-md-6 mb-4">
      @php $href = route('admin.users.index'); @endphp
      <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Pengguna</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usersCount }} terdaftar</div>
          </div>
          <a href="{{ $href }}" class="btn btn-sm btn-outline-secondary">Lihat</a>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      @php $href = route('admin.internships.index'); @endphp
      <div class="card border-left-dark shadow h-100 py-2">
        <div class="card-body d-flex justify-content-between align-items-center">
          <div>
            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pengajuan</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInt }} total</div>
          </div>
          <a href="{{ $href }}" class="btn btn-sm btn-outline-dark">Lihat</a>
        </div>
      </div>
    </div>
  </div>
@endsection
