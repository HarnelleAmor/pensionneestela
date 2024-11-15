<nav class="navbar bg-white fixed-top shadow">
    <div class="container">
        <!-- Logo and Brand Name -->
        <a href="{{ route('homepage') }}" class="navbar-brand d-none d-lg-block d-md-block d-sm-none d-flex align-items-center navbarbrand-logo" data-leave-check="true">
            <x-application-logo width="200" height="80"/>
        </a>

        <a href="{{ route('homepage') }}" class="navbar-brand d-block d-lg-none d-md-none d-sm-block d-flex align-items-center" data-leave-check="true">
            <img src="{{ asset('assets/images/estella2.png') }}" alt=""
                class="img-fluid" style="max-width: 80px;">
        </a>

        <ul class="navbar-nav flex-row ms-auto text-center d-none d-lg-flex d-md-flex d-sm-none">
            <li class="nav-item px-2 navitem-custom">
                <a href="{{ route('customerdashboard') }}"
                    class="nav-link text-uppercase text-dark navlink-custom {{ request()->routeIs('customerdashboard') ? 'active' : '' }}" data-leave-check="true">
                    Dashboard
                </a>
            </li>
            <li class="nav-item px-2 navitem-custom">
                <a href="{{ route('bookings.index') }}"
                    class="nav-link text-uppercase text-dark navlink-custom {{ request()->routeIs('bookings.index') ? 'active' : '' }}" data-leave-check="true">
                    Bookings
                </a>
            </li>
        </ul>

        @push('scripts')
            <script>
                function notificationsData() {
                    return {
                        unreadNotifications: [],
                        dotvisible: false,
                        unreaddot: false,
                        async fetchUnreadNotifications() {
                            try {
                                let response = await fetch("{{ route('unread.index') }}", {
                                    headers: {
                                        'Accept': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest',
                                    }
                                });
                                if (!response.ok) throw new Error('Network response was not ok');

                                this.unreadNotifications = await response.json();
                                this.dotvisible = this.unreaddot = this.unreadNotifications.length > 0;
                            } catch (error) {
                                console.error('Error fetching unread notifications:', error);
                            }
                        }
                    }
                }
            </script>
        @endpush
        <div class="ms-auto me-3" x-data="{
            openNotif: false,
            ...notificationsData(),
            toggleNotif() {
                if (this.openNotif) {
                    this.closeNotif()
                } else {
                    this.$refs.buttonNotif.focus()
                    this.openNotif = true
                }
            },
            closeNotif(focusAfter) {
                if (!this.openNotif) return
                this.openNotif = false
                focusAfter && focusAfter.focus()
            }
        }" x-init="fetchUnreadNotifications()"
            x-on:keydown.escape.prevent.stop="closeNotif($refs.buttonNotif)" x-id="['notif-dropdown-button']">
            <button x-ref="buttonNotif" x-on:click="toggleNotif(), dotvisible = false" :aria-expanded="openNotif"
                :aria-controls="$id('notif-dropdown-button')" type="button"
                class="btn btn-light border-0 p-3 rounded-circle d-inline-flex align-items-center">
                <div class="position-relative d-inline-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                        class="bi bi-bell" viewBox="0 0 16 16">
                        <path
                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                    </svg>
                    <span x-show="dotvisible" style="display: none;"
                        class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger p-1"><span
                            class="visually-hidden">unread messages</span></span>
                </div>
            </button>
            <div x-show="openNotif" x-transition.origin.top.right x-on:click.outside="closeNotif()"
                :id="$id('notif-dropdown-button')" style="display: none; right: 0;"
                class="position-absolute mt-2 mx-3 mb-3 p-3 col-lg-5 col-md-7 col-sm-8 rounded-3 bg-white shadow">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h3 class="mb-0 fw-semibold">Unread Notifications</h3>
                    {{-- <div class="dropdown">
                        <button type="button" class="btn btn-light border-0 p-2 rounded-circle d-inline-flex"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
                                <path
                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                            <li><a class="dropdown-item icon-link" href="#"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                    <path
                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0" />
                                </svg>Mark all as read</a></li>
                            <li><a class="dropdown-item icon-link" href="#" data-leave-check="true"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                                    </svg>Open Notifications</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="overflow-y-auto" style="height: 24rem;">
                    <livewire:notification />
                </div>
            </div>
        </div>
        <div class="dropdown d-none d-lg-block d-md-block">
            <button
                class="nav-link text-bg-sage dropdown-toggle bg-light d-flex align-items-center px-4 py-2 rounded-3 shadow gap-2"
                role="button" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                </svg>
                <p class="text-start mb-0 fw-medium">{{ auth()->user()->first_name }}
                    {{ auth()->user()->last_name }}<span
                        class="d-block mt-n1 small fw-normal">{{ ucfirst(auth()->user()->usertype) }}</span>
                </p>
            </button>
            <ul class="dropdown-menu dropdown-menu-end border-0 rounded-3 shadow mt-1">
                <li>
                    <a class="dropdown-item icon-link" href="{{ route('profile.edit') }}"
                        data-leave-check="true"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" fill="currentColor" class="bi bi-file-earmark-person"
                            viewBox="0 0 16 16">
                            <path d="M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                            <path
                                d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2v9.255S12 12 8 12s-5 1.755-5 1.755V2a1 1 0 0 1 1-1h5.5z" />
                        </svg>Profile</a>
                </li>
                <li>
                    <form id="logoutForm" action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-box-arrow-right me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                <path fill-rule="evenodd"
                                    d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
        <button class="navbar-toggler d-block d-lg-none d-md-none d-sm-block" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <div class="d-flex align-items-center gap-2" id="offcanvasNavbarLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-person-circle text-darkgreen" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg>
                    <p class="text-start mb-0 text-dark fw-medium">{{ auth()->user()->first_name }}
                        {{ auth()->user()->last_name }}<span
                            class="d-block mt-n1 text-muted small fw-normal">{{ ucfirst(auth()->user()->usertype) }}</span>
                    </p>
                </div>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-flex flex-column pe-4">
                <ul class="navbar-nav flex-grow-1">
                    <li class="nav-item mb-2">
                        <a class="btn btn-sage rounded-3 ps-4 gap-3 w-100 icon-link fs-6 fw-semibold shadow"
                            href="{{ route('homepage') }}" data-leave-check="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                                <path
                                    d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                            </svg>
                            Home
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="btn btn-sage rounded-3 ps-4 gap-3 w-100 icon-link fs-6 fw-semibold shadow"
                            href="{{ route('customerdashboard') }}" data-leave-check="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                                <path
                                    d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="btn btn-sage rounded-3 ps-4 gap-3 w-100 icon-link fs-6 fw-semibold shadow"
                            href="{{ route('bookings.index') }}" data-leave-check="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-collection" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 3.5a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1zm2-2a.5.5 0 0 1 0-1h7a.5.5 0 0 1 0 1zM0 13a1.5 1.5 0 0 0 1.5 1.5h13A1.5 1.5 0 0 0 16 13V6a1.5 1.5 0 0 0-1.5-1.5h-13A1.5 1.5 0 0 0 0 6zm1.5.5A.5.5 0 0 1 1 13V6a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-.5.5z" />
                            </svg>
                            Bookings
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-darkgreen border-0 rounded-3 px-4 gap-2 icon-link fs-6 fw-semibold"
                            href="{{ route('profile.edit') }}" data-leave-check="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                <path fill-rule="evenodd"
                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                            </svg>
                            Profile
                        </a>
                    </li>
                    <hr>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger border-0 rounded-3 px-4 gap-2 icon-link fs-6 fw-semibold"
                                data-leave-check="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd"
                                        d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
