@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white shadow rounded">
  <h1 class="text-2xl font-bold mb-4">Daftar Akun</h1>

  @if ($errors->any())
    <div class="mb-3 p-3 bg-red-100 text-red-700 rounded">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('register') }}" class="space-y-3">
    @csrf
    <div>
      <label class="block text-sm mb-1">Nama Lengkap</label>
      <input name="name" value="{{ old('name') }}" class="w-full border p-2 rounded" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded" required>
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input type="password" name="password" class="w-full border p-2 rounded" required>
      <small class="text-gray-500">Min 8 karakter, kombinasi huruf & angka</small>
    </div>
    <button class="w-full bg-blue-600 text-white py-2 rounded">Daftar</button>
  </form>

  <p class="text-sm mt-3">Sudah punya akun?
    <a href="{{ route('login') }}" class="text-blue-600 underline">Login</a>
  </p>
</div>
@endsection
