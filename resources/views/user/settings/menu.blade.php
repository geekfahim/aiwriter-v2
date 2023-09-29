<div class="bg-grey-light ps-2 pe-2 pt-2 pb-2 rounded position-sticky top-143">
    <a href="{{ url('settings') }}" class="btn fw-normal btn-sm {{ Request::segment(1) == "settings" ? 'btn-dark' : 'btn-outline-none' }} ps-1 pt-1 pb-1 w-100 text-start mb-2">{{ __('common.my_profile') }}</a>
    <a href="{{ url('billing') }}" class="btn fw-normal btn-sm {{ Request::segment(1) == "billing" ? 'btn-dark' : 'btn-outline-none' }} ps-1 pt-1 pb-1 w-100 text-start mb-2">{{ __('common.billing') }}</a>
</div>