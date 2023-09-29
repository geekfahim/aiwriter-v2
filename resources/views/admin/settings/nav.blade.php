<div class="card-body ps-4 pb-4">
    <div class="border-bottom-menu mt-3 mb-2 pb-2">
        <a href="{{ url('admin/settings/general') }}" class="text-dark">
            <img src="{{ url('images/icons/settings-24.png') }}" class="me-2">
            {{ __('General Settings') }}
        </a>
    </div>

    <div class="mt-3">
        <p class="mb-2 dropdown-menu-link pb-2 border-bottom-menu {{ Request::segment(3) == 'billing-info' || Request::segment(3) == 'plans' || Request::segment(3) == 'tax-rates' || Request::segment(3) == 'coupons' ? 'dropdown-active' : '' }}" role="button">
            <img src="{{ url('images/icons/bill-24.svg') }}" class="me-2">
            {{ __('Billing') }}
        </p>
    
        <ul class="sub-menu-list mt-3">
            <li>
                <a href="{{ url('admin/settings/billing-info') }}">{{ __('Billing Info') }}</a>
            </li>
            <li>
                <a href="{{ url('admin/settings/plans') }}">{{ __('Plans') }}</a>
            </li>
            <li>
                <a href="{{ url('admin/settings/tax-rates') }}">{{ __('Tax Rates') }}</a>
            </li>
            <li>
                <a href="{{ url('admin/settings/coupons') }}">{{ __('Coupons') }}</a>
            </li>
        </ul>
    </div>

    <div class="mt-3">
        <p class="mb-2 dropdown-menu-link pb-2 border-bottom-menu {{ Request::segment(3) == 'email-templates' || Request::segment(3) == 'smtp' ? 'dropdown-active' : '' }}" role="button">
            <img src="{{ url('images/icons/mail-24.png') }}" class="me-2">
            {{ __('Email Config') }}
        </p>
    
        <ul class="sub-menu-list mt-3">
            <li>
                <a href="{{ url('admin/settings/smtp') }}">{{ __('Settings') }}</a>
            </li>
            <li>
                <a href="{{ url('admin/settings/email-templates') }}">{{ __('Email Templates') }}</a>
            </li>
        </ul>
    </div>

    {{--  <div class="mt-3">
        <p class="mb-2 dropdown-menu-link pb-2 border-bottom-menu {{ Request::segment(3) == 'prompt-categories' || Request::segment(3) == 'prompts' ? 'dropdown-active' : '' }}" role="button">
            <img src="{{ url('images/icons/filetype-ai.svg') }}" class="me-2">
            {{ __('AI Prompts') }}
        </p>
    
        <ul class="sub-menu-list mt-3">
            <li>
                <a href="{{ url('admin/settings/prompt-categories') }}">{{ __('Categories') }}</a>
            </li>
            <li>
                <a href="{{ url('admin/settings/prompts') }}">{{ __('Prompt Templates') }}</a>
            </li>
        </ul>
    </div>  --}}

    <div class="border-bottom-menu mt-3 pb-2">
        <a href="{{ url('admin/settings/pages') }}" class="text-dark">
            <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M5 8v12h14V8H5zm0-2h14V4H5v2zm15 16H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1zM7 10h4v4H7v-4zm0 6h10v2H7v-2zm6-5h4v2h-4v-2z"/></svg></span>
            {{ __('Pages') }}
        </a>
    </div>

    <div class="border-bottom-menu mt-3 pb-2">
        <a href="{{ url('admin/settings/testimonials') }}" class="text-dark">
            <span class="me-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 20 20"><path fill="currentColor" d="M4 3h12c.55 0 1.02.2 1.41.59S18 4.45 18 5v7c0 .55-.2 1.02-.59 1.41S16.55 14 16 14h-1l-5 5v-5H4c-.55 0-1.02-.2-1.41-.59S2 12.55 2 12V5c0-.55.2-1.02.59-1.41S3.45 3 4 3zm11 2H4v1h11V5zm1 3H4v1h12V8zm-3 3H4v1h9v-1z"/></svg></span>
            {{ __('Testimonials') }}
        </a>
    </div>

    <div class="border-bottom-menu mt-3 pb-2">
        <a href="{{ url('admin/settings/team') }}" class="text-dark">
            <img src="{{ url('images/icons/users-24.png') }}" class="me-2">
            {{ __('Team') }}
        </a>
    </div>
    
    <div class="border-bottom-menu mt-3 pb-2">
        <a href="{{ url('admin/settings/integrations') }}" class="text-dark">
            <img src="{{ url('images/icons/api-24.png') }}" class="me-2">
            {{ __('Integrations') }}
        </a>
    </div>
</div>