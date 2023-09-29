@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header position-sticky top-0">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('Settings') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('Plans') }}</p>
            </div>
            <div class="col-md-6">
                <div class="pull-right-btn">
                    <button type="button" class="btn btn-primary btn-md mt-1 float-end js-add" data-url="{{ url('admin/settings/tax-rates/add') }}">
                        <span class="ion-plus">{{ 'Add Tax Rate' }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-body">
        <div class="row">
            <div class="col-md-3">
                <div class="card ml-4 mt-6 menu-list border-0 rounded position-sticky top-125">
                    @include('admin.settings.nav')
                </div>        
            </div>
            <div class="col-md-9">
                <table class="b-table w-100 sortable-table mt-6">
                    <thead>
                        <tr>
                            <th><span>{{ __('Name') }}</span></th>
                            <th><span>{{ __('Tax Rate') }}</span></th>
                            <th><span>{{ __('Status') }}</span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                        <tr>
                            <td>
                                <span>{{ $row->name }} ({{ $row->type }})</span>
                            </td>
                            <td>{{ $row->percentage.'%' }}</td>
                            <td class="text-capitalize">
                                <span class="badge {{ $row->status == 'active' ? 'bg-success' : 'bg-danger' }}">{{ $row->status }}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" class="">
                                        <i class="fas fa-ellipsis-v fa-xs"></i>
                                    </span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li>
                                            <button type="button" class="dropdown-item js-edit" data-url="{{ url('admin/settings/tax-rates/edit/'.$row->id) }}">{{ __('Edit') }}</button>
                                        </li>
                                        @if ($row->status == 'active')
                                        <li>
                                            <button type="button" class="dropdown-item js-change-status" data-url="{{ url('admin/settings/tax-rates/deactivate/'.$row->id) }}" data-message="{{ __('Please confirm that you want to deactivate this plan.') }}">{{ __('Deactivate') }}</button>
                                        </li>
                                        @elseif ($row->status == 'inactive')
                                        <li>
                                            <button type="button" class="dropdown-item js-change-status" data-url="{{ url('admin/settings/tax-rates/activate/'.$row->id) }}" data-message="{{ __('Please confirm that you want to activate this plan.') }}">{{ __('Activate') }}</button>
                                        </li>
                                        @endif
                                        <li>
                                            <button type="button" class="dropdown-item js-change-status" data-url="{{ url('admin/settings/tax-rates/delete/'.$row->id) }}" data-message="{{ __('Please confirm that you want to delete this plan.') }}">{{ __('Delete') }}</button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>   
             </div>
        </div>
    </div>
</div>
<div class="js-modal-view"></div>
@endsection
