@extends('admin.layouts.app')
@section('title','Pengajuan/Peserta - '.config('app.name'))

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 text-gray-800 mb-0">Pengajuan/Peserta</h1>
    <form class="form-inline" method="get">
      <label class="mr-2 small text-muted">Filter:</label>
      <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
        @foreach(['awaiting_letter'=>'Belum Upload','waiting_confirmation'=>'Menunggu','active'=>'Aktif','rejected'=>'Ditolak','all'=>'Semua'] as $k=>$v)
          <option value="{{ $k }}" @selected(($status??'')===$k)>{{ $v }}</option>
        @endforeach
      </select>
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
            <th>Status</th>
            <th>Surat Pemohon</th>
            <th>Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($internships as $i)
            <tr>
              <td>{{ $loop->iteration + ($internships->currentPage()-1)*$internships->perPage() }}</td>
              <td>{{ $i->user->name }}</td>
              <td>{{ $i->user->email }}</td>
              <td>
                @php $map=['awaiting_letter'=>'warning','waiting_confirmation'=>'info','active'=>'success','rejected'=>'danger']; @endphp
                <span class="badge badge-{{ $map[$i->status] ?? 'light' }}">{{ strtoupper(str_replace('_',' ',$i->status)) }}</span>
              </td>
              <td>
                @if($i->letter_path)
                  <a target="_blank" href="{{ asset('storage/'.$i->letter_path) }}" class="btn btn-outline-primary btn-sm">Lihat PDF</a>
                @else
                  <span class="text-muted">—</span>
                @endif
              </td>
              <td>{{ $i->created_at->format('d M Y') }}</td>
              <td>
                <a href="{{ route('admin.internships.show',$i) }}" class="btn btn-primary btn-sm">Detail</a>
              </td>
            </tr>
          @empty
            <tr><td colspan="7" class="text-center text-muted">Tidak ada data.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($internships->hasPages())
      <div class="card-footer">{{ $internships->links() }}</div>
    @endif
  </div>
@endsection
