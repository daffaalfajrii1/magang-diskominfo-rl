@extends('admin.layouts.app')
@section('title','Peserta Aktif - '.config('app.name'))

@section('content')
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h1 class="h3 text-gray-800 mb-0">Peserta Aktif</h1>
    <form class="form-inline" method="get">
      <input type="text" name="q" value="{{ $search ?? '' }}" class="form-control form-control-sm mr-2" placeholder="Cari nama/email">
      <button class="btn btn-sm btn-outline-secondary">Cari</button>
    </form>
  </div>

  <div class="card shadow">
    <div class="card-body table-responsive">
      <table class="table table-sm table-hover align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Periode</th>
            <th>Biodata</th>
            <th>Laporan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        @forelse($internships as $i)
          @php
            $hasProfile = (bool) $i->profile_completed_at;
            $hasReport  = (bool) $i->final_report_uploaded_at;
          @endphp
          <tr>
            <td>{{ $loop->iteration + ($internships->currentPage()-1)*$internships->perPage() }}</td>
            <td class="text-nowrap">{{ $i->user->name }}</td>
            <td class="text-nowrap"><a href="mailto:{{ $i->user->email }}">{{ $i->user->email }}</a></td>
            <td class="text-nowrap">
              @if($i->start_date && $i->end_date)
                {{ $i->start_date->format('d M Y') }} – {{ $i->end_date->format('d M Y') }}
              @else
                <span class="text-muted">Belum diisi</span>
              @endif
            </td>
            <td>
              @if($hasProfile)
                <span class="badge badge-success">Lengkap</span>
              @else
                <span class="badge badge-warning">Belum diisi</span>
              @endif
            </td>
            <td>
              @if($hasReport)
                <span class="badge badge-info">Ada</span>
              @else
                <span class="badge badge-light">Belum ada</span>
              @endif
            </td>
            <td class="text-nowrap">
              <a href="{{ route('admin.internships.show', $i) }}" class="btn btn-primary btn-sm">Detail</a>
              <a href="{{ route('admin.internships.show', [$i, '#biodata']) }}" class="btn btn-outline-secondary btn-sm">Lihat Biodata</a>
              <a href="{{ route('admin.internships.show', [$i, '#laporan']) }}" class="btn btn-outline-info btn-sm">Lihat Laporan</a>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center text-muted">Tidak ada peserta aktif.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
    @if($internships->hasPages())
      <div class="card-footer">{{ $internships->links() }}</div>
    @endif
  </div>
@endsection
