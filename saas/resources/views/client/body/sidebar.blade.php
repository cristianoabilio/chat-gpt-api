<div class="nk-sidebar nk-sidebar-fixed" id="sidebar">
    <div class="nk-compact-toggle">
        <button class="btn btn-xs btn-outline-light btn-icon compact-toggle text-light bg-white rounded-3">
            <em class="icon off ni ni-chevron-left"></em>
            <em class="icon on ni ni-chevron-right"></em>
        </button>
    </div>
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="index.html" class="logo-link">
                <div class="logo-wrap">
                    <img class="logo-img logo-light" src="{{ asset('backend/images/logo.png') }}" srcset="{{ asset('backend/images/logo2x.png 2x') }}" alt="">
                    <img class="logo-img logo-dark" src="{{ asset('backend/images/logo-dark.png') }}" srcset="{{ asset('backend/images/logo-dark2x.png 2x') }}" alt="">
                    <img class="logo-img logo-icon" src="{{ asset('backend/images/logo-icon.png') }}" srcset="{{ asset('backend/images/logo-icon2x.png 2x') }}" alt="">
                </div>
            </a>
        </div><!-- end nk-sidebar-brand -->
    </div><!-- end nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content h-100" data-simplebar>
            <div class="nk-sidebar-menu">
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{ url('/') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-dashboard-fill"></em>
                            </span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-folder-list"></em>
                            </span>
                            <span class="nk-menu-text">Account</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('user.profile') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Profile</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('user.change.password') }}" class="nk-menu-link">
                                    <span class="nk-menu-text">Change Password</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('user.template') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-user"></em>
                            </span>
                            <span class="nk-menu-text">Template</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('user.document') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-user"></em>
                            </span>
                            <span class="nk-menu-text">Documents</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('user.profile') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-user"></em>
                            </span>
                            <span class="nk-menu-text">Profile</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('user.logout') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-signin"></em>
                            </span>
                            <span class="nk-menu-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element nk-sidebar-footer">
        <div class="nk-sidebar-footer-extended pt-3">
            <div class="border border-light rounded-3">

                @php
                    $id = Auth::user()->id;
                    $profile = App\Models\User::find($id);

                    $wordLimit = $profile->plan->monthly_word_limit ?? 1000;

                    $totalWords = $profile->current_word_usage ?? 1000;

                    $wordUsed = $profile->word_used ?? 0;

                    $leftWords = max(0, $totalWords - $wordUsed);
                    $percentageUsed = $totalWords > 0
                        ? min(100, ($wordUsed / $totalWords) * 100)
                        : 0;

                @endphp

                <div class="px-3 py-2 bg-white border-bottom border-light rounded-top-3">
                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                        <h6 class="lead-text">{{ $profile->plan->name }} Plan</h6>
                        <a class="link link-primary" href="{{ route('user.profile') }}">
                            <em class="ni ni-spark-fill icon text-warning"></em>
                            <span>Upgrade</span>
                        </a>
                    </div>
                    <div class="progress progress-md">
                        <div class="progress-bar" data-progress="{{ $percentageUsed }}%" style="width: round($percentageUsed, 2)% "></div>
                    </div>
                    <h6 class="lead-text mt-2">{{ $leftWords }}<span class="text-light">words left</span></h6>
                </div>

                @php
                    $id = Auth::user()->id;
                    $profile = App\Models\User::find($id);
                @endphp
                <a class="d-flex px-3 py-2 bg-primary bg-opacity-10 rounded-bottom-3" href="profile.html">
                    <div class="media-group">
                        <div class="media media-sm media-middle media-circle text-bg-primary">
                            <img src="{{ ! empty($profile->photo) ? url('upload/user_images/' . $profile->photo) : asset('backend/images/avatar/a.png') }}" />
                        </div>
                        <div class="media-text">
                            <h6 class="fs-6 mb-0">{{ $profile->name }}</h6>
                            <span class="text-light fs-7">{{ $profile->email }}</span>
                        </div>
                        <em class="icon ni ni-chevron-right ms-auto ps-1"></em>
                    </div>
                </a>
            </div>
        </div>
    </div><!-- .nk-sidebar-element -->
</div><!-- .nk-sidebar -->