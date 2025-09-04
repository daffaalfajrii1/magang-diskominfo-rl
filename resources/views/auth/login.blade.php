@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="max-w-md mx-auto p-6 bg-white shadow rounded">
  <h1 class="text-2xl font-bold mb-4">Login</h1>

  @if ($errors->any())
    <div class="mb-3 p-3 bg-red-100 text-red-700 rounded">{{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-3">
    @csrf
    <div>
      <label class="block text-sm mb-1">Email</label>
      <input type="email" name="email" class="w-full border p-2 rounded" required autofocus>
    </div>
    <div>
      <label class="block text-sm mb-1">Password</label>
      <input type="password" name="password" class="w-full border p-2 rounded" required>
    </div>
    <label class="inline-flex items-center text-sm">
      <input type="checkbox" name="remember" class="mr-2"> Remember me
    </label>
    <button class="w-full bg-blue-600 text-white py-2 rounded">Login</button>
  </form>
</div>
@endsection
