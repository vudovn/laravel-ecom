<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('admin.dashboard.index') }}" class="b-brand text-primary">
                <img src="/admin_asset/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo">
            </a>
        </div>
        <div class="navbar-content">

            {{-- user --}}
            <div class="card pc-user-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0"><img src="https://ableproadmin.com/assets/images/user/avatar-1.jpg"
                                alt="user-image" class="user-avtar wid-45 rounded-circle"></div>
                        <div class="flex-grow-1 ms-3 me-2">
                            <h6 class="mb-0" data-i18n="Jonh Smith">Jonh Smith</h6><small
                                data-i18n="Administrator">Administrator</small>
                        </div><a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse"
                            href="#pc_sidebar_userlink"><svg class="pc-icon">
                                <use xlink:href="#custom-sort-outline"></use>
                            </svg></a>
                    </div>
                    <div class="collapse pc-user-links" id="pc_sidebar_userlink">
                        <div class="pt-3"><a href="#!"><i class="ti ti-user"></i> <span data-i18n="My Account">My
                                    Account</span> </a><a href="#!"><i class="ti ti-settings"></i> <span
                                    data-i18n="Settings">Settings</span> </a><a href="#!"><i
                                    class="ti ti-lock"></i>
                                <span data-i18n="Lock Screen">Lock Screen</span> </a><a href="#!"><i
                                    class="ti ti-power"></i> <span data-i18n="Logout">Logout</span></a></div>
                    </div>
                </div>
            </div>

            {{-- menu --}}
            <ul class="pc-navbar">
                <li class="pc-item pc-caption"><label data-i18n="Navigation">Navigation</label></li>

                <li class="pc-item">
                    <a href="{{ route('admin.users.index') }}" class="pc-link"><span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-user"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext">Quản lý người dùng</span>
                    </a>
                </li>

                {{-- menu có dropdown --}}
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><svg class="pc-icon">
                                <use xlink:href="#custom-document"></use>
                            </svg> </span><span class="pc-mtext" data-i18n="Layouts">Layouts</span> <span
                            class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="../demo/layout-vertical.html"
                                data-i18n="Vertical">Vertical</a></li>
                        <li class="pc-item"><a class="pc-link" href="../demo/layout-horizontal.html"
                                data-i18n="Horizontal">Horizontal</a></li>
                        <li class="pc-item"><a class="pc-link" href="../demo/layout-color-header.html"
                                data-i18n="Layouts 2">Layouts 2</a></li>
                        <li class="pc-item"><a class="pc-link" href="../demo/layout-compact.html"
                                data-i18n="Compact">Compact</a></li>
                        <li class="pc-item"><a class="pc-link" href="../demo/layout-tab.html" data-i18n="Tab">Tab</a>
                        </li>
                    </ul>
                </li>

                {{-- menu đơn --}}
                <li class="pc-item">
                    <a href="../widget/w_statistics.html" class="pc-link"><span class="pc-micon">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-story"></use>
                            </svg>
                        </span>
                        <span class="pc-mtext" data-i18n="Statistics">Statistics</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
