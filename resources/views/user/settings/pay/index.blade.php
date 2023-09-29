<!-- Modal -->
@extends('user.settings.pay.layout')
@section('content')
<div class="modal-header pb-3">
    <div class="modal-title">
        <h4 class="mb-0">{{ __('Payment') }}</h4>
        <small class="text-muted">{{ __('Purchase new plan') }}</small>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light">
    <div class="mb-3 row">
        <div class="col-md-7 d-flex mb-2">
            <div class="flex-shrink-0">
                @php 
                    if ($period == 'monthly') {
                        $subtotal = $plan->monthly_price;
                    } else {
                        $subtotal = $plan->yearly_price;
                    }
                    $whole = (int) $subtotal;
                    $decimal  = $subtotal - $whole;
                @endphp
                <span class="display-6 text-dark">{{ CurrencyHelper::format_with_currency($whole) }}<span class="fs-3">.{{ $decimal }}</span></span>
            </div>
            <div class="flex-grow-1 align-self-end ms-3 mb-2">
                <span class="d-block fw-bold text-muted">{{ $period == 'monthly' ? __('/mo') : __('/yr') }}</span>
            </div>
        </div>
        <div class="col-md-5">
            @php
                $switchPeriod = $period == 'monthly' ? 'yearly' : 'monthly'; 
            @endphp
            @if($whole > 0)
                <button class="btn btn-dark btn-sm btn-pointer w-100 pt-2 pb-2 js-pay-plan" data-url="{{ url('pay/'.$plan->id.'/'.$switchPeriod) }}">
                    {{ __('Switch to') }} {{ $switchPeriod }} 

                    @if ($period == 'monthly')
                        @php
                            $yearly_price_monthly = $plan->monthly_price * 12;
                            $save_percent = CurrencyHelper::format_number(($yearly_price_monthly - $plan->yearly_price) / $yearly_price_monthly * 100);
                        @endphp
                        @if ($yearly_price_monthly > $plan->yearly_price)
                            <br> {{ __('Save ').$save_percent.'%' }}
                        @endif
                    @endif
                </button>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <ul class="list-checked list-checked-soft-bg-warning fs-5 mb-2">
                <li class="list-checked-item">{{ $plan->words == 0 ? __('Unlimited') : CurrencyHelper::format_number($plan->words) }} {{ __('words /mo') }}</li>
                <li class="{{ $plan->allow_export ? 'list-checked-item' : 'list-unchecked-item' }}">{{ __('Export as PDF/Word') }}</li>
                @if ($period == 'monthly')
                    @if($plan->monthly_token > 0)
                        <li class="list-checked-item">{{ $plan->monthly_token }} Token</li>
                    @else
                        <li class="list-unchecked-item">Token</li>
                    @endif
                @else
                    @if($plan->yearly_token > 0)
                        <li class="list-checked-item">{{ $plan->yearly_token }} Token</li>
                    @else
                        <li class="list-unchecked-item">Token</li>
                    @endif
                @endif                
            </ul>
        </div>
    </div>
</div>
<form method="POST" action="{{ url('pay/'.$plan->id.'/'.$period) }}">
    @csrf
    <div class="modal-body">
        <span class="divider-start fs-5 fw-bold text-dark mb-2">{{ __('Payment Method') }}</span>
        <div class="mb-4">
            <div>
                @foreach ($payment_methods as $method)
                <input type="radio" class="btn-check" name="payment_platform" value="{{ $method->id }}" id="btnradio{{ $method->id }}" autocomplete="off" @if ($loop->first) checked @endif>
                <label class="btn btn-sm btn-outline-dark me-2 mb-2 fs-5" for="btnradio{{ $method->id }}">{{ $method->name }}</label>
                @endforeach
            </div>
        </div>
        <div class="mb-4">
            <span class="small">{{ __('Have a coupon code?') }}</span>
            @if (Session::has('couponCode'))
                <span class="border-bottom p-1 small js-add-coupon" role="button" data-url="{{ url('add-coupon/'.$plan->id.'/'.$period) }}">
                    {{ Session::get('couponCode') }}
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 7H6a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-5m-7 1L20 4m-5 0h5v5"/></svg>
                </span>  
                <span class="ms-2 small p-1 js-remove-coupon" role="button" data-url="{{ url('remove-coupon/'.$plan->id.'/'.$period) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 36 36"><path fill="currentColor" d="M18 2a16 16 0 1 0 16 16A16 16 0 0 0 18 2Zm8 22.1a1.4 1.4 0 0 1-2 2l-6-6l-6 6.02a1.4 1.4 0 1 1-2-2l6-6.04l-6.17-6.22a1.4 1.4 0 1 1 2-2L18 16.1l6.17-6.17a1.4 1.4 0 1 1 2 2L20 18.08Z" class="clr-i-solid clr-i-solid-path-1"/><path fill="none" d="M0 0h36v36H0z"/></svg>
                    {{ __('Remove') }}
                </span>
            @else
                <span class="border-bottom small js-add-coupon" role="button" data-url="{{ url('add-coupon/'.$plan->id.'/'.$period) }}">{{ __('Add coupon code') }}</span>
            @endif
        </div>
        <span class="divider-start fs-5 fw-bold text-dark mb-2">{{ __('Purchase Summary') }}</span>
        <div class="table-responsive-sm mb-3">
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <th scope="row">
                            <span class="fs-5">{{ $plan->name }}</span>
                        </th>
                        <td class="table-text-center">
                            <span class="fs-5 float-end">{{ CurrencyHelper::format_with_currency($subtotal) }}</span>
                        </td>
                    </tr>
                    @if (session()->has('couponCode'))
                    <tr>
                        <th scope="row">
                            <span class="fs-5">{{ $discount.'% ' . __('Coupon Code Discount') }}</span>
                        </th>
                        <td class="table-text-center">
                            <span class="fs-5 float-end text-danger">-{{ CurrencyHelper::format_with_currency($subtotal * $discount / 100) }}</span>
                        </td>
                    </tr>
                    @endif
                    @foreach ($taxRates as $taxRate)
                    <tr>
                        <th scope="row">
                            <span class="fs-5">{{ $taxRate->name }} ({{ CurrencyHelper::format_number($taxRate->percentage).'% '.$taxRate->type }})</span>
                        </th>
                        <td class="table-text-center">
                            <span class="fs-5 float-end">{{ CurrencyHelper::format_with_currency(CurrencyHelper::checkoutExclusiveTax($subtotal, $discount, $taxRate->percentage, $inclTaxRatesPercentage)) }}</span>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th scope="row">
                            <span class="fs-4 fw-bold">{{ __('Total') }}</span>
                            <small class="badge badge-sm bg-primary ms-3 text-capitalize">{{ __('Billed') }} {{ $period }}</small>
                        </th>
                        <td class="table-text-center">
                            <h5 class="float-end">{{ CurrencyHelper::format_with_currency(CurrencyHelper::checkoutTotal($subtotal, $discount, $exclTaxRatesPercentage, $inclTaxRatesPercentage)) }}</h5>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <small class="text-muted" style="font-size: 10px">
            {{ __('By continuing, you agree with the terms of service and authorize us to charge your payment method on a recurring basis. You can cancel your subscription at any time.') }}
        </small>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
        <button type="submit" class="btn btn-sm btn-dark btn-pointer js-checkout-form-submit-btn">{{ __('Proceed to Pay') }}</button>
    </div>
</form>
@endsection