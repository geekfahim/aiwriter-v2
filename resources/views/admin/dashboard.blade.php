@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>{{ __('common.dashboard') }}</h3>
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row">
            <div class="col-md-3">
                <div class="card border-0 rounded">
                    <div class="card-body">
                        <h5 class="mb-4">
                            <i data-feather="users"></i>
                            {{ __('Customers') }}
                        </h5>
                        <h4>{{ CurrencyHelper::format_no_currency($customersTotal) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 rounded">
                    <div class="card-body">
                        <h5 class="mb-4">
                            <i data-feather="toggle-right"></i>
                            {{ __('Active Subscriptions') }}
                        </h5>
                        <h4>{{ CurrencyHelper::format_no_currency($subscriptionsTotal) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 rounded">
                    <div class="card-body">
                        <h5 class="mb-4">
                            <i data-feather="dollar-sign"></i>
                            {{ __('Revenue') }}
                        </h5>
                        <h4>{{ CurrencyHelper::format_with_currency($billingTotal) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 rounded">
                    <div class="card-body">
                        <h5 class="mb-4">
                            <i data-feather="edit-3"></i>
                            {{ __('Content Generated') }}
                        </h5>
                        <h4>{{ CurrencyHelper::format_no_currency($contentTotal) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="card-body pt-4 pb-4">
                        <div class="row">
                            @php
                                $totalUsers = DB::table('users')->count();
                                $countryCounts = DB::table('users')->select('country', DB::raw('count(*) as count'))
                                    ->where('country','!=', NULL)
                                    ->groupBy('country')
                                    ->orderBy('count', 'desc')
                                    ->take(5)
                                    ->get();

                                $otherCount = DB::table('users')->select('country', DB::raw('count(*) as count'))
                                    ->groupBy('country')
                                    ->orderBy('count', 'desc')
                                    ->get()
                                    ->sum('count');
                            @endphp
                            <div class="col-md-12">
                                <h5>{{ __('Customers By Country') }}</h5>
                                @foreach ($countryCounts as $countryCount)
                                    @php
                                        $percentage = $countryCount->count / $totalUsers * 100;
                                        $flagClass = 'flag-icon flag-icon-' . strtolower($countryCount->country);
                                    @endphp
                                    <div class="row mb-2">
                                        <div class="col-10">
                                            <span>{{ $countryCount->country }}</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-2 align-self-end">
                                            <span class="ms-2">{{ round($percentage, 2) }}%</span>
                                        </div>
                                    </div>
                                @endforeach
                                @if ($otherCount > 0)
                                    @php
                                        $percentage = $otherCount / $totalUsers * 100;
                                    @endphp
                                    <div class="row mb-2">
                                        <div class="col-10">
                                            <i data-feather="flag"></i>
                                            <span>{{ __('Other Countries') }}</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-2 align-self-end">
                                            <span class="ms-2">{{ round($percentage, 2) }}%</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 rounded">
                    <div class="card-body pt-4 pb-4">
                        <h5>{{ __('Top 5 Commonly Used Templates') }}</h5>
                        <div>
                            <ul>
                                @foreach ($topTemplates as $template)
                                <li class="text-capitalize">{{ $template->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
