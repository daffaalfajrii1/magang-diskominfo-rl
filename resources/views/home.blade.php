@extends('layouts.app')

@section('title', 'Magang Diskominfo')

@push('head')
  {{-- Font & style khusus halaman ini --}}
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); }
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
  </div>
@endsection
