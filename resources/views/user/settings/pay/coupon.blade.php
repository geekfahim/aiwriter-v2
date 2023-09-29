@extends('user.settings.pay.layout')
@section('content')
<form method="POST" action="{{ url('add-coupon/'.$planId.'/'.$period) }}" class="js-coupon-form">
    @csrf
    <div class="modal-header pb-3">
        <div class="modal-title">
            <h4 class="mb-0">{{ __('Add Coupon Code') }}</h4>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body bg-light">
        <div class="form-group">
            <label class="small">{{ __('Coupon Code') }}</label>
            <input type="text" class="form-control form-control-sm" name="code" value="{{ Session::get('couponCode') ?? null }}">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-white js-pay-plan" data-url="{{ url('pay/'.$planId.'/yearly') }}">{{ __('Cancel') }}</button>
        <button type="button" class="btn btn-sm btn-dark js-submit-coupon-form">{{ __('Add Coupon Code') }}</button>
    </div>
</form>
@endsection