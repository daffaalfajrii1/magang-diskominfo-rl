<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
    <div class="sidebar-brand-text mx-3">InternTrack</div>
  </a>

  <hr class="sidebar-divider my-0">

  <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  {{-- (nanti) menu Konfirmasi Surat, Peserta Aktif, Pesan, dll --}}
  {{-- <li class="nav-item"><a class="nav-link" href="{{ route('admin.submissions') }}"><i class="fas fa-fw fa-inbox"></i><span>Pengajuan</span></a></li> --}}

  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
