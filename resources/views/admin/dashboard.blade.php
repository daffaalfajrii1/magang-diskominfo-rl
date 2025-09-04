@extends('admin.layouts.app')
@section('title','Admin Dashboard - InternTrack')

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Dashboard Admin</h1>

  <div class="row">
    <div class="col-md-4 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Pengajuan Baru</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Aktif</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">—</div>
        </div>
      </div>
    </div>
  </div>
@endsection
