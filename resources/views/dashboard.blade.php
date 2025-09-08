@extends('layouts.app')
@section('title', 'Dashboard - '.config('app.name'))

@push('head')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    .timeline-step { position: relative; padding-left: 2.5rem; }
    .timeline-step:not(:last-child):after { content: ''; position: absolute; left: 1.25rem; top: 2.5rem; height: calc(100% - 2.5rem); width: 2px; background-color: #e5e7eb; }
    .timeline-icon { position: absolute; left: 0; width: 2.5rem; height: 2.5rem; border-radius: 50%; display:flex; align-items:center; justify-content:center; color:#fff; }
    .completed{ background:#10b981; } .current{ background:#3b82f6; } .pending{ background:#9ca3af; }
    .badge { border-radius: 999px; padding: .15rem .5rem; font-size: .75rem; font-weight: 600; }
  </style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

  <div class="mb-8 flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
      <p class="mt-2 text-sm text-gray-600">Pantau progres pendaftaran magang kamu</p>
    </div>
    <div class="flex items-center gap-3">
      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
        {{ $user->name }}
      </span>
      <form method="POST" action="{{ route('logout') }}">@csrf
        <button type="submit" class="px-3 py-1 rounded bg-red-600 text-white text-sm hover:bg-red-700">Logout</button>
      </form>
    </div>
  </div>

  @if(session('success')) <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div> @endif
  @if($errors->any())     <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ $errors->first() }}</div> @endif

  {{-- RINGKASAN --}}
  <div class="bg-white shadow overflow-hidden rounded-lg mb-8">
    <div class="gradient-bg px-4 py-5 sm:px-6"><h3 class="text-lg font-medium leading-6 text-white">Ringkasan</h3></div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
      <dl class="sm:divide-y sm:divide-gray-200">

        {{-- Foto --}}
        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Foto</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            @if($internship->photo_path)
              <img src="{{ asset('storage/'.$internship->photo_path) }}" class="h-16 w-16 rounded-full object-cover border" alt="Foto">
            @else
              <span class="text-gray-500">Belum diunggah</span>
            @endif
          </dd>
        </div>

        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $internship->full_name ?? $user->name }}</dd>
        </div>

        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Email</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
        </div>

        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Status</dt>
          <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
            @php
              $labelMap = [
                'awaiting_letter'      => ['Upload Surat','bg-amber-100 text-amber-800'],
                'waiting_confirmation' => ['Menunggu Konfirmasi','bg-blue-100 text-blue-800'],
                'active'               => ['Aktif','bg-green-100 text-green-800'],
                'rejected'             => ['Ditolak','bg-red-100 text-red-800'],
                'completed'            => ['Selesai Magang','bg-gray-200 text-gray-800'],
              ];
              [$text,$cls] = $labelMap[$internship->status] ?? [strtoupper($internship->status),'bg-gray-100 text-gray-800'];
            @endphp
            <span class="badge {{ $cls }}">{{ $text }}</span>
          </dd>
        </div>

      </dl>
    </div>
  </div>

  {{-- DOKUMEN & PESAN ADMIN --}}
  <div class="bg-white shadow overflow-hidden rounded-lg mb-8">
    <div class="gradient-bg px-4 py-3 sm:px-6"><h3 class="text-lg font-medium leading-6 text-white">Dokumen & Pesan Admin</h3></div>
    <div class="px-4 py-5 sm:p-6 space-y-4">
      <div>
        <div class="font-semibold text-gray-800 mb-1">Surat Balasan Admin</div>
        @if($internship->approval_letter_path)
          <a class="inline-flex items-center px-3 py-1 text-sm bg-green-600 text-white rounded hover:bg-green-700"
             target="_blank" href="{{ asset('storage/'.$internship->approval_letter_path) }}">Unduh Surat Balasan (PDF)</a>
          @if($internship->confirmed_at)
            <div class="text-xs text-gray-500 mt-1">Diterbitkan {{ $internship->confirmed_at->format('d M Y') }}</div>
          @endif
        @else
          <div class="text-sm text-gray-500">Belum ada surat balasan.</div>
        @endif
      </div>

      <hr>

      <div>
        <div class="font-semibold text-gray-800 mb-2">Pesan dari Admin</div>
        @forelse(($internship->messages ?? []) as $msg)
          <div class="border rounded p-3 mb-2">
            <div class="text-xs text-gray-500 mb-1">
              {{ $msg->created_at->format('d M Y H:i') }} • Admin: {{ $msg->admin->name ?? 'Admin' }}
            </div>
            @if($msg->subject)<div class="font-medium">{{ $msg->subject }}</div>@endif
            <div class="text-sm">{{ $msg->body }}</div>
          </div>
        @empty
          <div class="text-sm text-gray-500">Belum ada pesan.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- STATUS / TIMELINE --}}
  @if($internship->status === 'completed')
    {{-- Panel selesai (timeline disembunyikan) --}}
    <div class="bg-white shadow overflow-hidden rounded-lg">
      <div class="gradient-bg px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-white">Status</h3>
      </div>
      <div class="px-4 py-6 sm:p-6">
        <div class="p-4 rounded bg-gray-50 text-gray-800">
          <div class="text-xl font-semibold mb-1">Selesai Magang 🎉</div>
          <p class="text-sm">
            Terima kasih telah menyelesaikan magang di DISKOMINFO Rejang Lebong.
            @if($internship->final_report_path)
              <br>Laporan akhir: <a target="_blank" class="text-blue-600 underline" href="{{ asset('storage/'.$internship->final_report_path) }}">Lihat</a>.
            @endif
            @if($internship->approval_letter_path)
              <br>Surat balasan: <a target="_blank" class="text-blue-600 underline" href="{{ asset('storage/'.$internship->approval_letter_path) }}">Unduh PDF</a>.
            @endif
          </p>
        </div>
      </div>
    </div>
  @else
    {{-- TIMELINE SEDERHANA --}}
    <div class="bg-white shadow overflow-hidden rounded-lg">
      <div class="gradient-bg px-4 py-5 sm:px-6"><h3 class="text-lg font-medium leading-6 text-white">Timeline</h3></div>
      <div class="px-4 py-5 sm:p-6">
        <div class="space-y-8">

          {{-- STEP 1: Upload Surat --}}
          <div class="timeline-step">
            <div class="timeline-icon {{ $internship->status === 'awaiting_letter' ? 'current' : 'completed' }}">
              <i data-feather="{{ $internship->status === 'awaiting_letter' ? 'upload' : 'check' }}" class="w-4 h-4"></i>
            </div>
            <div class="pl-4">
              <h4 class="text-lg font-medium text-gray-900">Upload Surat Magang (PDF)</h4>
              @if($internship->status === 'awaiting_letter')
                <p class="mt-1 text-sm text-gray-600">Unggah surat pengantar dari sekolah/kampus (PDF, maks 5MB).</p>
                <form method="POST" action="{{ route('internship.letter.upload') }}" enctype="multipart/form-data" class="mt-3 flex items-center gap-3">
                  @csrf
                  <input type="file" name="letter" accept="application/pdf" class="border p-2 rounded" required>
                  <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">Unggah</button>
                </form>
              @else
                <p class="mt-1 text-sm">
                  Surat:
                  @if($internship->letter_path)
                    <a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$internship->letter_path) }}">Lihat PDF</a>
                  @else <span class="text-gray-500">—</span> @endif
                </p>
              @endif
            </div>
          </div>

          {{-- STEP 2: Keputusan Admin --}}
          <div class="timeline-step">
            @php
              $icon2 = $internship->status === 'active' ? 'check' : ($internship->status === 'waiting_confirmation' ? 'clock' : ($internship->status === 'rejected' ? 'x' : 'lock'));
              $cls2  = $internship->status === 'active' ? 'completed' : ($internship->status === 'waiting_confirmation' ? 'current' : ($internship->status === 'rejected' ? 'completed' : 'pending'));
            @endphp
            <div class="timeline-icon {{ $cls2 }}"><i data-feather="{{ $icon2 }}" class="w-4 h-4"></i></div>
            <div class="pl-4">
              <h4 class="text-lg font-medium text-gray-900">Keputusan Admin</h4>
              @if($internship->status === 'waiting_confirmation')
                <p class="mt-1 text-sm text-gray-600">Surat kamu sedang ditinjau.</p>
              @elseif($internship->status === 'active')
                <p class="mt-1 text-sm text-gray-600">Selamat! Kamu telah diterima sebagai peserta magang (AKTIF) sejak {{ optional($internship->confirmed_at)->format('d M Y') }}.</p>
              @elseif($internship->status === 'rejected')
                <div class="mt-1 p-3 rounded bg-red-50 text-red-700 text-sm">Maaf, pengajuan kamu <strong>ditolak</strong> oleh admin. Lihat pesan admin di bagian atas.</div>
              @else
                <p class="mt-1 text-sm text-gray-600">Tahap ini aktif setelah kamu mengunggah surat.</p>
              @endif
            </div>
          </div>

          {{-- STEP 3: Biodata (hanya untuk ACTIVE) --}}
          @if($internship->status === 'active')
          <div class="timeline-step">
            @php $profileState = $internship->profile_completed_at ? 'completed' : 'current'; @endphp
            <div class="timeline-icon {{ $profileState }}"><i data-feather="{{ $profileState==='completed'?'check':'edit-3' }}" class="w-4 h-4"></i></div>
            <div class="pl-4">
              <h4 class="text-lg font-medium text-gray-900">Isi Biodata Lengkap</h4>
              <form method="POST" action="{{ route('internship.profile.save') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-3">
                @csrf
                <div class="md:col-span-2">
                  <label class="block text-sm mb-1">Email</label>
                  <input class="border p-2 rounded w-full bg-gray-100" value="{{ $user->email }}" readonly>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm mb-1">Nama Lengkap</label>
                  <input class="border p-2 rounded w-full" name="full_name" value="{{ old('full_name', $internship->full_name ?? $user->name) }}" required>
                </div>
                <div><label class="block text-sm mb-1">No. WhatsApp</label><input class="border p-2 rounded w-full" name="whatsapp" value="{{ old('whatsapp', $internship->whatsapp) }}" required></div>
                <div><label class="block text-sm mb-1">Asal Sekolah/Kampus</label><input class="border p-2 rounded w-full" name="school" value="{{ old('school', $internship->school) }}" required></div>
                <div><label class="block text-sm mb-1">Jurusan/Prodi</label><input class="border p-2 rounded w-full" name="major" value="{{ old('major', $internship->major) }}" required></div>
                <div><label class="block text-sm mb-1">NIS/NIM (opsional)</label><input class="border p-2 rounded w-full" name="student_id" value="{{ old('student_id', $internship->student_id) }}"></div>
                <div><label class="block text-sm mb-1">Tanggal Mulai</label><input type="date" class="border p-2 rounded w-full" name="start_date" value="{{ old('start_date', $internship->start_date?->toDateString()) }}" required></div>
                <div><label class="block text-sm mb-1">Tanggal Selesai</label><input type="date" class="border p-2 rounded w-full" name="end_date" value="{{ old('end_date', $internship->end_date?->toDateString()) }}" required></div>
                <div class="md:col-span-2">
                  <label class="block text-sm mb-1">Alamat Lengkap</label>
                  <textarea class="border p-2 rounded w-full" rows="3" name="address" required>{{ old('address', $internship->address) }}</textarea>
                </div>
                <div class="md:col-span-2">
                  <label class="block text-sm mb-1">Foto (jpg/png/webp, maks 2MB) — opsional</label>
                  <input type="file" name="photo" accept="image/*" class="border p-2 rounded w-full">
                  @if($internship->photo_path)
                    <div class="mt-2 text-xs text-gray-600">
                      Foto saat ini: <a target="_blank" class="text-blue-600 underline" href="{{ asset('storage/'.$internship->photo_path) }}">Lihat</a>
                    </div>
                  @endif
                </div>
                <div class="md:col-span-2">
                  <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan Data</button>
                  @if($internship->profile_completed_at)
                    <span class="ml-2 text-xs px-2 py-1 rounded bg-green-100 text-green-800">Tersimpan {{ $internship->profile_completed_at->format('d M Y') }}</span>
                  @endif
                </div>
              </form>
            </div>
          </div>

          {{-- STEP 4: Laporan (setelah selesai, maks 10 hari) --}}
          <div class="timeline-step">
            @php
              $canUploadReport = $internship->end_date && $internship->canUploadReport();
              $reportState = $internship->final_report_uploaded_at ? 'completed' : ($canUploadReport ? 'current' : 'pending');
              $deadline = $internship->end_date ? $internship->end_date->copy()->addDays(10) : null;
            @endphp
            <div class="timeline-icon {{ $reportState }}"><i data-feather="{{ $reportState==='completed'?'check':($reportState==='current'?'upload':'lock') }}" class="w-4 h-4"></i></div>
            <div class="pl-4">
              <h4 class="text-lg font-medium text-gray-900">Unggah Laporan Akhir</h4>
              @if($internship->final_report_uploaded_at)
                <p class="mt-1 text-sm text-gray-600">
                  Laporan diunggah {{ $internship->final_report_uploaded_at->format('d M Y') }}.
                  @if($internship->final_report_path)
                    <br><a target="_blank" href="{{ asset('storage/'.$internship->final_report_path) }}" class="text-blue-600 underline">Lihat Laporan</a>
                  @endif
                </p>
              @elseif(!$internship->end_date)
                <p class="mt-1 text-sm text-gray-600">Lengkapi tanggal selesai magang di biodata terlebih dahulu.</p>
              @else
                <p class="mt-1 text-sm text-gray-600">
                  Laporan dapat diunggah dari {{ $internship->end_date->format('d M Y') }}
                  hingga {{ $deadline->format('d M Y') }} (maksimal 10 hari setelah selesai).
                </p>
                @if($canUploadReport)
                  <form method="POST" action="{{ route('internship.final_report.upload') }}" enctype="multipart/form-data" class="mt-3 flex items-center gap-3">
                    @csrf
                    <input type="file" name="final_report" accept="application/pdf" class="border p-2 rounded" required>
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">Unggah Laporan</button>
                  </form>
                @else
                  <p class="mt-2 text-xs text-gray-500">Belum dalam rentang waktu unggah atau sudah lewat batas.</p>
                @endif
              @endif
            </div>
          </div>
          @endif

        </div>
      </div>
    </div>
  @endif
</div>
@endsection
