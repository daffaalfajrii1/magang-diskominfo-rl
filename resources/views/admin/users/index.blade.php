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
              {{-- nomor urut sesuai pagination --}}
              <td>{{ $loop->iteration + ($users->currentPage()-1)*$users->perPage() }}</td>

              {{-- data akun --}}
              <td>{{ $u->name }}</td>
              <td>{{ $u->email }}</td>

              {{-- role --}}
              <td>
                <span class="badge badge-{{ $u->role==='admin'?'primary':'secondary' }}">
                  {{ strtoupper($u->role) }}
                </span>
              </td>

              {{-- status magang (dari internship terbaru) --}}
              <td>
                @php
                  $st = $u->latestInternship?->status ?? null;
                  $map = [
                    'awaiting_letter'      => ['AWAITING LETTER','warning'],
                    'waiting_confirmation' => ['WAITING CONFIRMATION','info'],
                    'active'               => ['ACTIVE','success'],
                    'rejected'             => ['REJECTED','danger'],
                    'completed'            => ['COMPLETED','dark'],
                  ];
                  [$label,$cls] = $map[$st] ?? ['—','light'];
                @endphp
                <span class="badge badge-{{ $cls }}">{{ $label }}</span>
              </td>

              {{-- tanggal registrasi akun --}}
              <td>{{ $u->created_at->format('d M Y') }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted">Belum ada pengguna.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- pagination --}}
    @if($users->hasPages())
      <div class="card-footer">{{ $users->links() }}</div>
    @endif
  </div>
@endsection
