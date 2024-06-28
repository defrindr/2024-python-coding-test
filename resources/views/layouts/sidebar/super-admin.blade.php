<div class="sidebar-content h-75 d-flex flex-column justify-content-between">
  <ul>
    <li class="{{ request()->routeIs('dashboard.super-admin') ? 'active' : '' }}">
      <a href="{{ route('dashboard.super-admin') }}" class="link">
        <i class="ti-home"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="menu-category">
      <span class="text-uppercase">Management Data</span>
    </li>
    <li class="{{ request()->routeIs(['guru*', 'admin*', 'siswa*', 'super-admin*']) ? 'active' : '' }}">
      <a href="#" class="main-menu has-dropdown">
        <i class="fa-solid fa-users"></i>
        <span>User</span>
      </a>
      <ul class="sub-menu">
        <li>
          <a href="{{ route('admin.index') }}" class="link"><span>Admin Sekolah</span></a>
        </li>
        <li>
          <a href="{{ route('guru.index') }}" class="link"><span>Guru</span></a>
        </li>
        <li>
          <a href="{{ route('siswa.index') }}" class="link"><span>Siswa</span></a>
        </li>
      </ul>
    </li>
    <li class="{{ request()->routeIs(['sekolah*', 'kelas*', 'course*']) ? 'active' : '' }}">
      <a href="#" class="main-menu has-dropdown">
        <i class="fa-solid fa-school"></i>
        <span>Sekolah & Modul</span>
      </a>
      <ul class="sub-menu">
        <li>
          <a href="{{ route('sekolah.index') }}" class="link"> <span>Mitra Sekolah</span></a>
        </li>
        <li>
          <a href="{{ route('kelas.index') }}" class="link"> <span>Kelas</span></a>
        </li>
        <li>
          <a href="{{ route('course.index') }}" class="link"> <span>Course</span></a>
        </li>
      </ul>
    </li>
    <li class="{{ request()->routeIs(['permission*']) ? 'active' : '' }}">
      <a href="{{ route('permission.index') }}" class="link">
        <i class="ti-alert"></i>
        <span>Permission</span>
      </a>
    </li>
    <li class="{{ request()->routeIs('manualbook.index') ? 'active' : '' }}">
      <a href="{{ route('manualbook.index') }}" class="link">
        <i class="ti-book"></i>
        <span>Manual Book</span>
      </a>
    </li>
  </ul>
  <ul>
    <li class="mt-auto">
      <a href="#" class="link">
        <i class="ti-link"></i>
        <span>FEEDBACK</span>
      </a>
    </li>
  </ul>
</div>
