<div class="sidebar-content">
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
                    <a href="element-card.html" class="link"><span>Super Admin</span></a>
                </li>
                <li>
                    <a href="{{ route('admin.index') }}" class="link"><span>Admin Sekolah</span></a>
                </li>
                <li>
                    <a href="{{ route('guru.index') }}" class="link"><span>Guru</span></a>
                </li>
                <li>
                    <a href="element-tabs-collapse.html" class="link"><span>Siswa</span></a>
                </li>
            </ul>
        </li>
        <li class="{{ request()->routeIs(['sekolah*', 'kelas*']) ? 'active' : '' }}">
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
                    <a href="form-element.html" class="link"> <span>Course</span></a>
                </li>
                <li>
                    <a href="form-datepicker.html" class="link"> <span>Modul</span></a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#" class="link">
                <i class="ti-alert"></i>
                <span>Permission</span>
            </a>
        </li>
    </ul>
</div>
