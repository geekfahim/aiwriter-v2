<div class="sidebar" id="mySidebar">
    <div class="logo mt-5">
        @if (Helper::config('logo'))
            <img src="{{ asset('uploads/brand/' . Helper::config('logo')) }}">
        @else
            <h5 class="text-dark mb-0 ps-3 border-dashed mt-2">{{ __('Upload Logo') }}</h5>  
        @endif
    </div>
    <div class="sidebar-container">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{ url('admin/dashboard') }}" class="{{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="M4 13h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1zm0 8h6c.55 0 1-.45 1-1v-4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v4c0 .55.45 1 1 1zm10 0h6c.55 0 1-.45 1-1v-8c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1zM13 4v4c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1h-6c-.55 0-1 .45-1 1z"/></svg>
            <span>{{ __('common.dashboard') }}</span>
        </a>
        <a href="{{ url('admin/customers') }}" class="{{ Request::segment(1) == 'customers' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0a4.125 4.125 0 0 1-8.25 0Zm9.75 2.25a3.375 3.375 0 1 1 6.75 0a3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63a13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122Zm15.75.003l-.001.144a2.25 2.25 0 0 1-.233.96a10.088 10.088 0 0 0 5.06-1.01a.75.75 0 0 0 .42-.643a4.875 4.875 0 0 0-6.957-4.611a8.586 8.586 0 0 1 1.71 5.157v.003Z"/></svg>
            <span>{{ __('Customers') }}</span>
        </a>
        <a href="{{ url('admin/subscriptions') }}" class="{{ Request::segment(1) == 'subscriptions' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.758 8.758L5.344 7.344a8.048 8.048 0 0 0-1.841 2.859l1.873.701a6.048 6.048 0 0 1 1.382-2.146zM19 12.999a7.935 7.935 0 0 0-2.344-5.655A7.917 7.917 0 0 0 12 5.069V2L7 6l5 4V7.089a5.944 5.944 0 0 1 3.242 1.669A5.956 5.956 0 0 1 17 13v.002c0 .33-.033.655-.086.977c-.007.043-.011.088-.019.131a6.053 6.053 0 0 1-1.138 2.536c-.16.209-.331.412-.516.597a5.954 5.954 0 0 1-.728.613a5.906 5.906 0 0 1-2.277 1.015c-.142.03-.285.05-.43.069c-.062.009-.122.021-.184.027a6.104 6.104 0 0 1-1.898-.103L9.3 20.819a8.087 8.087 0 0 0 2.534.136c.069-.007.138-.021.207-.03c.205-.026.409-.056.61-.098l.053-.009l-.001-.005a7.877 7.877 0 0 0 2.136-.795l.001.001l.028-.019a7.906 7.906 0 0 0 1.01-.67c.27-.209.532-.43.777-.675c.248-.247.47-.513.681-.785c.021-.028.049-.053.07-.081l-.006-.004a7.899 7.899 0 0 0 1.093-1.997l.008.003c.029-.078.05-.158.076-.237c.037-.11.075-.221.107-.333c.04-.14.073-.281.105-.423c.022-.099.048-.195.066-.295c.032-.171.056-.344.076-.516c.01-.076.023-.15.03-.227c.023-.249.037-.5.037-.753c.002-.002.002-.004.002-.008zM6.197 16.597l-1.6 1.201a8.045 8.045 0 0 0 2.569 2.225l.961-1.754a6.018 6.018 0 0 1-1.93-1.672zM5 13c0-.145.005-.287.015-.429l-1.994-.143a7.977 7.977 0 0 0 .483 3.372l1.873-.701A5.975 5.975 0 0 1 5 13z"/></svg>
            <span>{{ __('Subscriptions') }}</span>
        </a>
        <a href="{{ url('admin/billing') }}" class="{{ Request::segment(1) == 'billing' ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M12 2v6.5a1.5 1.5 0 0 0 1.5 1.5H20v10a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h6Zm3 13H9a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2Zm-5-4H9a1 1 0 1 0 0 2h1a1 1 0 1 0 0-2Zm4-8.957a2 2 0 0 1 1 .543L19.414 7a2 2 0 0 1 .543 1H14Z"/></g></svg>
            <span>{{ __('Billing') }}</span>
        </a>
       
            <a class="mb-2 dropdown-menu-link pb-2 ai-prompts {{ Request::segment(1) == 'ai-prompts' ? 'active' : '' }}" >
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
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="M3.5 2h-1v5h1V2zm6.1 5H6.4L6 6.45v-1L6.4 5h3.2l.4.5v1l-.4.5zm-5 3H1.4L1 9.5v-1l.4-.5h3.2l.4.5v1l-.4.5zm3.9-8h-1v2h1V2zm-1 6h1v6h-1V8zm-4 3h-1v3h1v-3zm7.9 0h3.19l.4-.5v-.95l-.4-.5H11.4l-.4.5v.95l.4.5zm2.1-9h-1v6h1V2zm-1 10h1v2h-1v-2z" clip-rule="evenodd"/></svg>
            <span>{{ __('Settings') }}</span>
        </a>
        <a href="{{ url('admin/logout') }}" class="d-none d-md-block">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8m4-9l-4-4m4 4l-4 4m4-4H9"/></svg>
            <span>{{ __('Logout') }}</span>
        </a>
    </div>
    <div class="sidebar-footer pb-3 bg-white">
        <div class="sidebar-footer__profile">
            <div tabindex="0">
                <button type="button" class="border-0 bg-white rounded footer-container-box user-menu-footer ps-3 pe-4 pt-1 pb-1">
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