<div class="navbar-header">
    <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <a href="javascript: void(0);" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="https://kmspros.com/wp-content/uploads/2022/12/KMS-Logo-White-Shadow-01.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="https://kmspros.com/wp-content/uploads/2022/12/KMS-Logo-White-Shadow-01.png" alt="" height="17">
                </span>
            </a>

            <a href="javascript: void(0);" class="logo logo-light">
                <span class="logo-sm">
                    <img src="https://kmspros.com/wp-content/uploads/2022/12/KMS-Logo-White-Shadow-01.png" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="https://kmspros.com/wp-content/uploads/2022/12/KMS-Logo-White-Shadow-01.png" alt="" height="19">
                </span>
            </a>
        </div>

        <button type="button" class="btn btn-sm px-3 font-size-16 d-lg-none header-item waves-effect waves-light"
            data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
            <i class="fa fa-fw fa-bars"></i>
        </button>

        @livewire('component.layout.header-menu', key('header-menu'))
    </div>

    <div class="d-flex">

        <div class="dropdown d-none d-lg-inline-block ms-1">
            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                <i class="bx bx-fullscreen"></i>
            </button>
        </div>

        <div class="dropdown d-inline-block">
            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="rounded-circle header-profile-user" src="https://ih1.redbubble.net/image.5054474200.8259/ur,pin_large_front,square,600x600.webp"
                    alt="Header Avatar">
                <span class="d-xl-inline-block ms-1" key="t-henry">{{ $name }}</span>
                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <!-- item-->
                <a class="dropdown-item" href="{{ route('profile') }}"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span
                        key="t-profile">Profile</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" wire:click="logout"><i
                        class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                        key="t-logout">Logout</span></a>
            </div>
        </div>
    </div>
</div>
