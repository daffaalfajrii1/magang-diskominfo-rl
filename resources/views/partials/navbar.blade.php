<nav class="bg-white shadow-sm">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex items-center">
        <div class="flex-shrink-0 flex items-center">
          <i data-feather="briefcase" class="text-blue-600 h-8 w-8"></i>
          <span class="ml-2 text-xl font-semibold text-blue-600">
            {{ config('app.name', 'MagangDiskominfo') }}
          </span>
        </div>
      </div>
      <div class="flex items-center space-x-4">
        @guest
          <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 px-3 py-2 rounded-md text-sm font-medium">
            Register
          </a>
          <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
            Login
          </a>
        @endguest
        @auth
          <a href="" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
            Dashboard
          </a>
        @endauth
      </div>
    </div>
  </div>
</nav>
