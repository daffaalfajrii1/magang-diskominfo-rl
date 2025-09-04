<!DOCTYPE html>
<html lang="id">
<head>
  @include('admin.partials.head')
</head>
<body id="page-top">
  <div id="wrapper">
    @include('admin.partials.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        @include('admin.partials.topbar')

        <div class="container-fluid">
          {{-- Konten halaman --}}
          @yield('content')
        </div>
      </div>

      @include('admin.partials.footer')
    </div>
  </div>

  @include('admin.partials.scripts')
</body>
</html>
