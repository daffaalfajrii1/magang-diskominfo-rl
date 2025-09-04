<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>

  {{-- Tailwind CDN (boleh ganti ke @vite kalau mau) --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Font default project bisa di-override per page via @push('head') --}}
  @stack('head')
</head>
<body class="min-h-screen bg-slate-50 text-gray-900">

  {{-- Navbar --}}
  @include('partials.navbar')

  {{-- Flash & error --}}
  @if(session('success'))
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
      <div class="p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    </div>
  @endif
  @if($errors->any())
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
      <div class="p-3 rounded bg-red-100 text-red-800">{{ $errors->first() }}</div>
    </div>
  @endif

  {{-- Konten --}}
  <main>
    @yield('content')
  </main>

  {{-- Footer --}}
  @include('partials.footer')

  {{-- Feather icons --}}
  <script src="https://unpkg.com/feather-icons"></script>
  <script>feather.replace();</script>

  @stack('scripts')
</body>
</html>
