<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('AdminDashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('admin/assets/img/logo.png') }}" alt="">
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">
                @php
                    $user = Auth::user();
                @endphp
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="{{ asset('admin/assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">Dashboard</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>
                            @php
                                $roles = [];
                                if ($user->UserDetail->partner) {
                                    $roles[] = 'Partner';
                                }
                                if ($user->UserDetail->investor) {
                                    $roles[] = 'Investor';
                                }
                            @endphp
                            {{ implode(' & ', $roles) }}
                        </h6>


                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @hasPermission('change_password')
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('User.ChangePassword') }}">
                                <i class="bi bi-gear"></i>
                                <span>Change Password</span>
                            </a>
                        </li>
                    @endhasPermission
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->
