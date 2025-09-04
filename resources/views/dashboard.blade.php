@extends('layouts.app')

@section('title', 'Dashboard - Magang Diskominfo')

@push('head')
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    .timeline-step { position: relative; padding-left: 2.5rem; }
    .timeline-step:not(:last-child):after {
      content: ''; position: absolute; left: 1.25rem; top: 2.5rem;
      height: calc(100% - 2.5rem); width: 2px; background-color: #e5e7eb;
    }
    .timeline-icon {
      position: absolute; left: 0; width: 2.5rem; height: 2.5rem;
      border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;
    }
    .completed{ background-color:#10b981; }
    .current  { background-color:#3b82f6; }
    .pending  { background-color:#9ca3af; }
  </style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

  {{-- Header --}}
  <div class="mb-8 flex items-center justify-between">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Application Dashboard</h1>
      <p class="mt-2 text-sm text-gray-600">Track your internship application progress</p>
    </div>
    <div class="flex items-center">
      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
        {{ $user->name }}
      </span>
       <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
        class="px-3 py-1 rounded bg-red-600 text-white text-sm hover:bg-red-700">
        Logout
      </button>
    </form>
    </div>
  </div>

  {{-- Summary --}}
  <div class="bg-white shadow overflow-hidden rounded-lg mb-8">
    <div class="gradient-bg px-4 py-5 sm:px-6">
      <h3 class="text-lg font-medium leading-6 text-white">Application Summary</h3>
    </div>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
      <dl class="sm:divide-y sm:divide-gray-200">
        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Full name</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
        </div>
        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Email</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
        </div>
        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Application Status</dt>
          <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
            @php
              $badge = [
                'awaiting_letter'     => ['bg'=>'bg-amber-100','text'=>'text-amber-800','label'=>'Upload Surat'],
                'waiting_confirmation'=> ['bg'=>'bg-blue-100', 'text'=>'text-blue-800', 'label'=>'Menunggu Konfirmasi'],
                'confirmed'           => ['bg'=>'bg-green-100','text'=>'text-green-800','label'=>'Dikonfirmasi'],
              ][$internship->status] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-800','label'=>strtoupper($internship->status)];
            @endphp
            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badge['bg'] }} {{ $badge['text'] }}">
              {{ $badge['label'] }}
            </span>
          </dd>
        </div>
        @if($internship->letter_uploaded_at)
        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">Uploaded At</dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ $internship->letter_uploaded_at->format('d M Y H:i') }}
          </dd>
        </div>
        @endif
      </dl>
    </div>
  </div>

  {{-- Timeline --}}
  <div class="bg-white shadow overflow-hidden rounded-lg">
    <div class="gradient-bg px-4 py-5 sm:px-6">
      <h3 class="text-lg font-medium leading-6 text-white">Application Timeline</h3>
    </div>
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
                <button class="inline-flex items-center px-4 py-2 text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                  Unggah
                </button>
              </form>
            @else
              <p class="mt-1 text-sm">
                Surat:
                @if($internship->letter_path)
                  <a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$internship->letter_path) }}">Lihat PDF</a>
                @else
                  <span class="text-gray-500">—</span>
                @endif
              </p>
              <p class="mt-1 text-xs text-gray-500">Completed on {{ optional($internship->letter_uploaded_at)->format('d M Y') }}</p>
            @endif
          </div>
        </div>

        {{-- STEP 2: Menunggu Konfirmasi Admin --}}
        <div class="timeline-step">
          <div class="timeline-icon {{ $internship->status === 'waiting_confirmation' ? 'current' : ($internship->status === 'confirmed' ? 'completed' : 'pending') }}">
            <i data-feather="{{ $internship->status === 'confirmed' ? 'check' : 'clock' }}" class="w-4 h-4"></i>
          </div>
          <div class="pl-4">
            <h4 class="text-lg font-medium text-gray-900">Menunggu Konfirmasi Admin</h4>
            <p class="mt-1 text-sm text-gray-600">
              @if($internship->status === 'waiting_confirmation')
                Surat kamu sedang ditinjau admin.
              @elseif($internship->status === 'confirmed')
                Dikonfirmasi pada {{ optional($internship->confirmed_at)->format('d M Y') }}.
              @else
                Tahap ini aktif setelah kamu mengunggah surat.
              @endif
            </p>
          </div>
        </div>

        {{-- STEP Berikutnya dikunci (nanti kita hidupkan) --}}
        <div class="timeline-step">
          <div class="timeline-icon pending"><i data-feather="lock" class="w-4 h-4"></i></div>
          <div class="pl-4">
            <h4 class="text-lg font-medium text-gray-900">Isi Data Diri Lengkap</h4>
            <p class="mt-1 text-sm text-gray-600">Akan terbuka setelah admin mengonfirmasi surat.</p>
          </div>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection
