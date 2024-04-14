<div class="sidebar-content">
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
        <li>
            <a href="#" class="main-menu has-dropdown">
                <i class="fa-solid fa-school"></i>
                <span>Course & Modul</span>
            </a>
            <ul class="sub-menu">
                <li>
                    <a href="form-element.html" class="link"> <span>Course</span></a>
                </li>
                <li>
                    <a href="form-datepicker.html" class="link"> <span>Modul</span></a>
                </li>
            </ul>
        </li>
    </ul>
</div>
