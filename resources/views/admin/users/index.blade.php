@extends('admin.layouts.app')
@section('title','Pengguna Terdaftar - '.config('app.name'))

@section('content')
  <h1 class="h3 mb-4 text-gray-800">Pengguna Terdaftar</h1>

  <div class="card shadow">
    <div class="card-body table-responsive">
      <table class="table table-sm table-hover align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status Magang</th>
            <th>Daftar</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $u)
            <tr>
              <td>{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>
              <td>{{ $u->name }}</td>
              <td>{{ $u->email }}</td>
              <td><span class="badge badge-{{ $u->role==='admin'?'primary':'secondary' }}">{{ $u->role }}</span></td>
              <td>
                @php
                  $st = $u->internship?->status ?? '—';
                  $map = [
                    'awaiting_letter'=>'warning',
                    'waiting_confirmation'=>'info',
                    'confirmed'=>'success',
                    'rejected'=>'danger'
                  ];
                  $cls = $map[$st] ?? 'light';
                @endphp
                <span class="badge badge-{{ $cls }}">{{ strtoupper(str_replace('_',' ',$st)) }}</span>
              </td>
              <td>{{ $u->created_at->format('d M Y') }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted">Belum ada pengguna.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    @if($users->hasPages())
      <div class="card-footer">{{ $users->links() }}</div>
    @endif
  </div>
@endsection
