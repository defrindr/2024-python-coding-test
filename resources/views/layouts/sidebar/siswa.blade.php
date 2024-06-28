<div class="sidebar-content h-75 d-flex flex-column justify-content-between">
  <ul>
    <li class="{{ request()->routeIs('dashboard.siswa') ? 'active' : '' }}">
      <a href="{{ route('dashboard.siswa') }}" class="link">
        <i class="ti-home"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="menu-category">
      <span class="text-uppercase">Course & Modul</span>
    </li>
    <li class="{{ request()->routeIs(['siswa.course*']) ? 'active' : '' }}">
      <a href="#" class="main-menu has-dropdown">
        <i class="fa-solid fa-school"></i>
        <span>Course & Modul</span>
      </a>
      <ul class="sub-menu">
        <li>
          <a href="{{ route('siswa.course.index') }}" class="link"> <span>Course</span></a>
        </li>
      </ul>
    </li>
  </ul>
  <ul>
    <li class="mt-auto">
      <a href="" class="link">
        <i class="ti-link"></i>
        <span>FEEDBACK</span>
      </a>
    </li>
  </ul>
</div>
