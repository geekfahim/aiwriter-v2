<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ Helper::config('company_name') }}</title>
    <meta name="subscription" content="{{ Helper::generate_more_words() }}">
    <link rel="icon" type="image/png" href="{{ asset('uploads/brand/' . Helper::config('favicon')) }}"/>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme-style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.css') }}"/>

    <!-- JS -->
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
</head>
<body class="navbar-sidebar-aside-lg bg-grey-light">
    <div class="container-md p-3 mx-auto">
        <div class="content-space-md-1 px-lg-5 px-xl-10">
            <div class="row mb-4 no-print">
                <div class="col-md-6">
                    <a href="{{ url('billing') }}" class="link text-muted">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m9 14l-4-4l4-4"/><path d="M5 10h11a4 4 0 1 1 0 8h-1"/></g></svg>
                        <span>{{ __('Back To Dashboard') }}</span>
                    </a>
                </div>
                <div class="col-md-6">
                    <button type="button" onclick="window.print();" class="btn btn-sm btn-white border-0 p-2 ps-3 pe-3 float-end">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16"><g fill="currentColor"><path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/><path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102c.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645a19.697 19.697 0 0 0 1.062-2.227a7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136c.075-.354.274-.672.65-.823c.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538c.007.188-.012.396-.047.614c-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686a5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465c.12.144.193.32.2.518c.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416a.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95a11.651 11.651 0 0 0-1.997.406a11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238c-.328.194-.541.383-.647.547c-.094.145-.096.25-.04.361c.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193a11.744 11.744 0 0 1-.51-.858a20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41c.24.19.407.253.498.256a.107.107 0 0 0 .07-.015a.307.307 0 0 0 .094-.125a.436.436 0 0 0 .059-.2a.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198a.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283c-.04.192-.03.469.046.822c.024.111.054.227.09.346z"/></g></svg>
                        <span>{{ __('Print') }}</span>
                    </button>
                </div>
            </div>
            <!-- Card -->
            <div class="card border-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            @if (Helper::config('logo'))
                                <img class="navbar-brand-logo" src="{{ asset('uploads/brand/' . Helper::config('logo')) }}">
                            @else
                                <h5>{{ Helper::config('billing_vendor') }}</h5>  
                            @endif
                        </div>
                        <div class="col-8">
                            <h4 class="text-uppercase text-end">{{ __('Payment Receipt') }}</h4>
                            <p class="small mb-0 text-end">{{ __('Payment Date') }}: {{ date('d, M Y', strtotime($invoice->billing_date)) }}</p>
                            <p class="small mb-0 text-end">{{ __('Invoice Ref') }}: {{ Helper::config('billing_invoice_prefix').$invoice->billing_id }}</p>
                            <span class="float-end text-capitalize badge bg-grey-light text-dark">{{ $invoice->status }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-uppercase mb-2 small fw-bold">{{ __('From') }}</p>
                            <p class="small mb-0">{{ Helper::config('billing_vendor') }}</p>
                            <p class="small mb-0">{{ Helper::config('billing_address') }}</p>
                            <p class="small mb-0">{{ Helper::config('billing_city').', '.Helper::config('billing_country') }}</p>
                            <p class="small mb-0">{{ __('VAT') }} : {{ Helper::config('billing_tax_number') }}</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-text-center">
                            <thead>
                                <tr>
                                    <th class="border-bottom p-0 pb-2" style="border-bottom: 3px solid #000!important;" colspan="100%">
                                        <span class="float-start fw-normal">{{ __('Summary') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="small">
                                    <th class="p-0 pb-2 pt-3" style="border-bottom: 1px dashed rgba(220, 224, 229, 0.6);">
                                        <span class="float-start">{{ __('Plan').': '.$invoice->plan->name }} -
                                            <span class="text-capitalize">{{ __('Processed by') }} {{ $invoice->processor }}</span>
                                        </span>
                                        <br>
                                        <span class="float-start text-capitalize badge bg-grey-light text-dark">{{ __('Ref') }}: {{ $invoice->payment_id }}</span>
                                    </th>
                                    <td class="p-0 pb-2 pt-3" style="border-bottom: 1px dashed rgba(220, 224, 229, 0.6);">
                                        <h4 class="float-end">{{ CurrencyHelper::format_with_currency($invoice->amount, $invoice->currency) }}</h4>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
    
    <!-- JS Global Compulsory  -->
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/customer.js') }}"></script>
</body>
</html>