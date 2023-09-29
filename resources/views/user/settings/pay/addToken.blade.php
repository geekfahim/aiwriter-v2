<!-- Modal -->
@extends('user.settings.pay.layout')
@section('content')
<div class="modal-header pb-3">
    <div class="modal-title">
        <h4 class="mb-0">{{ __('Payment') }}</h4>
        <small class="text-muted">{{ __('Purchase more token') }}</small>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body bg-light">
    <div class="mb-3 row">
        <div class="col-md-7 d-flex mb-2">
            <div class="flex-shrink-0">
                <span class="display-6 text-dark">{{ CurrencyHelper::format_with_currency($token_amount) }}</span>
            </div>
        </div>
    </div>
</div>
<form method="POST" action="{{ url('/prompts/add/token/'.$token.'/'.$token_amount) }}">
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
        <span class="divider-start fs-5 fw-bold text-dark mb-2">{{ __('Purchase Summary') }}</span>
        <div class="table-responsive-sm mb-3">
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <th scope="row">
                            <span class="fs-5">Token</span>
                        </th>
                        <td class="table-text-center">
                            <span class="fs-5 float-end">{{ $token }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <span class="fs-5">Total</span>
                        </th>
                        <td class="table-text-center">
                            <h5 class="float-end">{{ CurrencyHelper::format_with_currency($token_amount) }}</h5>
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