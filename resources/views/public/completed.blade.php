@extends('layouts.app')
@section('title','Selesai Magang - '.config('app.name'))

@push('head')
<style>
  .card-shadow{ box-shadow:0 10px 25px rgba(0,0,0,.05); }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
  <div class="flex items-center justify-between mb-6">
    <div>
      <h1 class="text-3xl font-bold text-gray-900">Peserta Selesai Magang</h1>
      <p class="text-sm text-gray-600">Menampilkan alumni magang DISKOMINFO Rejang Lebong</p>
    </div>

    {{-- Navigasi panah (top) --}}
    @if($interns->hasPages())
      <div class="flex gap-2">
        @if($interns->onFirstPage())
          <span class="px-3 py-2 rounded bg-gray-100 text-gray-400 cursor-not-allowed">←</span>
        @else
          <a href="{{ $interns->previousPageUrl() }}" class="px-3 py-2 rounded bg-white border hover:bg-gray-50">←</a>
        @endif

        @if($interns->hasMorePages())
          <a href="{{ $interns->nextPageUrl() }}" class="px-3 py-2 rounded bg-white border hover:bg-gray-50">→</a>
        @else
          <span class="px-3 py-2 rounded bg-gray-100 text-gray-400 cursor-not-allowed">→</span>
        @endif
      </div>
    @endif
  </div>

  {{-- GRID KARTU --}}
  @if($interns->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($interns as $i)
        <div class="bg-white rounded-xl card-shadow overflow-hidden border">
          <div class="p-5">
            <div class="flex items-center gap-4">
              <img src="{{ $i->photo_url ?? asset('storage/'.$i->photo_path) }}"
                   onerror="this.src='https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ urlencode($i->full_name ?? $i->user->name) }}';"
                   alt="Foto {{ $i->full_name ?? $i->user->name }}"
                   class="h-16 w-16 rounded-full object-cover border">
              <div>
                <div class="text-base font-semibold text-gray-900">
                  {{ $i->full_name ?? $i->user->name }}
                </div>
                <div class="text-sm text-gray-500">{{ $i->school ?? '—' }}</div>
              </div>
            </div>

            <div class="mt-4 text-xs text-gray-500">
              Selesai: {{ optional($i->completed_at)->format('d M Y') ?? (optional($i->end_date)->format('d M Y') ?? '—') }}
            </div>

            <div class="mt-4">
              @if($i->final_report_path)
                <a target="_blank"
                   href="{{ asset('storage/'.$i->final_report_path) }}"
                   class="inline-flex items-center justify-center w-full px-3 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700">
                  Lihat Laporan
                </a>
              @else
                <span class="inline-flex items-center justify-center w-full px-3 py-2 rounded bg-gray-100 text-gray-500 text-sm">
                  Laporan belum ada
                </span>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- PAGINATION (8 per halaman) --}}
    <div class="mt-8 flex items-center justify-between">
      <div class="text-sm text-gray-600">
        Menampilkan
        <span class="font-semibold">{{ $interns->firstItem() }}</span>
        –
        <span class="font-semibold">{{ $interns->lastItem() }}</span>
        dari
        <span class="font-semibold">{{ $interns->total() }}</span>
      </div>

      <div class="flex gap-2">
        @if($interns->onFirstPage())
          <span class="px-3 py-2 rounded bg-gray-100 text-gray-400 cursor-not-allowed">← Sebelumnya</span>
        @else
          <a href="{{ $interns->previousPageUrl() }}" class="px-3 py-2 rounded bg-white border hover:bg-gray-50">← Sebelumnya</a>
        @endif

        @if($interns->hasMorePages())
          <a href="{{ $interns->nextPageUrl() }}" class="px-3 py-2 rounded bg-white border hover:bg-gray-50">Berikutnya →</a>
        @else
          <span class="px-3 py-2 rounded bg-gray-100 text-gray-400 cursor-not-allowed">Berikutnya →</span>
        @endif
      </div>
    </div>
  @else
    <div class="p-8 bg-white rounded-xl border text-center text-gray-500">
      Belum ada data selesai magang.
    </div>
  @endif
</div>
@endsection
