<div class="sidebar-content">
  <ul>
    <li class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
      <a href="{{ route('dashboard.admin') }}" class="link">
        <i class="ti-home"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="menu-category">
      <span class="text-uppercase">Management Data</span>
    </li>
    <li class="{{ request()->routeIs(['admin.guru*', 'siswa*']) ? 'active' : '' }}">
      <a href="#" class="main-menu has-dropdown">
        <i class="fa-solid fa-users"></i>
        <span>User</span>
      </a>
      <ul class="sub-menu">
        <li>
          <a href="{{ route('admin.guru.index') }}" class="link"><span>Guru</span></a>
        </li>
        <li>
          <a href="{{ route('siswa.index') }}" class="link"><span>Siswa</span></a>
        </li>
      </ul>
    </li>
    <li class="{{ request()->routeIs(['admin.kelas*', 'admin.course*']) ? 'active' : '' }}">
      <a href="#" class="main-menu has-dropdown">
        <i class="fa-solid fa-school"></i>
        <span>Kelas & Course</span>
      </a>
      <ul class="sub-menu">
        <li>
          <a href="{{ route('admin.kelas.index') }}" class="link"> <span>Kelas</span></a>
        </li>
        <li>
          <a href="{{ route('admin.course.index') }}" class="link"> <span>Course</span></a>
        </li>
      </ul>
    </li>
  </ul>
</div>