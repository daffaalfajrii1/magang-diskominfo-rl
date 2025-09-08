@extends('layouts.app')

@section('title', 'Magang Diskominfo')

@push('head')
  {{-- Font & style khusus halaman ini --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
    .card-shadow { box-shadow:0 10px 25px rgba(0,0,0,.05); }
  </style>
@endpush

@section('content')
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <div class="text-center">
      <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
        Find Your Perfect Internship
      </h1>
      <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
        Register now and track your application progress with our intuitive dashboard.
      </p>
      <div class="mt-8 flex justify-center space-x-4">
        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
          Get Started
          <i data-feather="arrow-right" class="ml-2 w-4 h-4"></i>
        </a>
        <a href="#features" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200">
          Learn More
        </a>
      </div>
    </div>

    <div id="features" class="mt-16">
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600">
            <i data-feather="file-text"></i>
          </div>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Easy Registration</h3>
          <p class="mt-2 text-base text-gray-500">
            Simple and intuitive registration process to get you started quickly.
          </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600">
            <i data-feather="clock"></i>
          </div>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Real-time Tracking</h3>
          <p class="mt-2 text-base text-gray-500">
            Track your application status in real-time with our interactive dashboard.
          </p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-100 text-blue-600">
            <i data-feather="bell"></i>
          </div>
          <h3 class="mt-4 text-lg font-medium text-gray-900">Notifications</h3>
          <p class="mt-2 text-base text-gray-500">
            Get notified about important updates and deadlines.
          </p>
        </div>
      </div>
    </div>

    {{-- Section Alumni --}}
    <div class="mt-20">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Alumni Magang Selesai</h2>
        <a href="{{ route('interns.completed') }}" class="text-blue-600 hover:underline">Lihat Semua →</a>
      </div>

      @php
        $alumni = \App\Models\Internship::with('user')
          ->where('status','completed')
          ->latest('completed_at')
          ->take(4)
          ->get();
      @endphp

      @if($alumni->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          @foreach($alumni as $a)
            <div class="bg-white rounded-xl card-shadow overflow-hidden border">
              <div class="p-5">
                <div class="flex items-center gap-4">
                  <img src="{{ $a->photo_url ?? asset('storage/'.$a->photo_path) }}"
                       onerror="this.src='https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ urlencode($a->full_name ?? $a->user->name) }}';"
                       class="h-14 w-14 rounded-full object-cover border">
                  <div>
                    <div class="text-base font-semibold text-gray-900">{{ $a->full_name ?? $a->user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $a->school ?? '—' }}</div>
                  </div>
                </div>
                <div class="mt-3">
                  @if($a->final_report_path)
                    <a href="{{ asset('storage/'.$a->final_report_path) }}" target="_blank"
                       class="inline-flex items-center px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                      Lihat Laporan
                    </a>
                  @else
                    <span class="text-sm text-gray-500">Laporan belum ada</span>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div class="p-6 bg-white rounded-xl border text-center text-gray-500">
          Belum ada alumni magang.
        </div>
      @endif
    </div>
  </div>
@endsection
