<div class="sidebar" id="mySidebar">
    <div class="logo mt-1">
        @if (Helper::config('logo'))
            <img src="{{ asset('uploads/brand/' . Helper::config('logo')) }}">
        @else
            <img src="{{ asset('images/logo.png') }}">
        @endif
    </div>
    <div class="sidebar-container">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ url('admin/dashboard') }}" class="{{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
            <i data-feather="home"></i>
            <span>{{ __('common.dashboard') }}</span>
        </a>
        <a href="{{ url('/') }}" class="{{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
            <i data-feather="dribbble"></i>
            <span>{{ __('common.website') }}</span>
        </a>
        <a href="{{ url('admin/customers') }}" class="{{ Request::segment(1) == 'customers' ? 'active' : '' }}">
            <i data-feather="users"></i>
            <span>{{ __('Customers') }}</span>
        </a>
        <a href="{{ url('admin/subscriptions') }}" class="{{ Request::segment(1) == 'subscriptions' ? 'active' : '' }}">
            <i data-feather="repeat"></i>
            <span>{{ __('Subscriptions') }}</span>
        </a>
        <a href="{{ url('admin/billing') }}" class="{{ Request::segment(1) == 'billing' ? 'active' : '' }}">
            <i data-feather="file-text"></i>
            <span>{{ __('Billing') }}</span>
        </a>
        <a class="mb-2 dropdown-menu-link pb-2 ai-prompts {{ Request::segment(1) == 'ai-prompts' ? 'active' : '' }}">
            <img src="{{ url('images/icons/filetype-ai.svg') }}" class="ai-svg">
            <span>{{ __('AI Prompts') }}</span>
        </a>

        <ul class="sub-menu-list mt-3 pl-50 side-bar-drop">
            <li class="p-0 border-0 mb-3">
                <a href="{{ url('admin/settings/prompt-categories') }}" class="p-0">{{ __('Categories') }}</a>
            </li>
            <li class="p-0 border-0 mb-3">
                <a href="{{ url('admin/settings/prompts') }}" class="p-0">{{ __('Prompt Templates') }}</a>
            </li>
        </ul>

        <hr class="ms-4 me-4">
        <a href="{{ url('admin/settings/general') }}" class="{{ Request::segment(1) == 'settings' ? 'active' : '' }}">
            <i data-feather="settings"></i>
            <span>{{ __('Settings') }}</span>
        </a>
        <a href="{{ url('admin/logout') }}" class="d-none d-md-block">
            <i data-feather="power"></i>
            <span>{{ __('Logout') }}</span>
        </a>
    </div>
    <div class="sidebar-footer pb-1 bg-white">
        <div class="sidebar-footer__profile">
            <div tabindex="0">
                <button type="button"
                        class="border-0 bg-white rounded footer-container-box user-menu-footer ps-3 pe-4 pt-1 pb-1">
                    <div class="col-3">
                        <div class="footer-rounded-initials me-3">
                            <span>
                            @php
                                $name = auth()->user()->first_name.' '.auth()->user()->last_name;
                                $parts = explode(" ", $name);
                                $initials = substr($parts[0], 0, 1) . substr($parts[1], 0, 1);
                                echo $initials;
                            @endphp
                            </span>
                        </div>
                    </div>
                    <div class="col-9 d-flex flex-col flex-grow">
                        <div class="sidebar-footer__profile_details text-start">
                            <p class="mb-0 sidebar-footer__profile_details-name fw-bold">{{ $name }}</p>
                            <p class="mb-0 sidebar-footer__profile_details-role">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>
