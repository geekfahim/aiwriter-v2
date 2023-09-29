@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header position-sticky top-0">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('Settings') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('settings') }}</p>
            </div>
            <div class="col-md-6">
                
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
                <table class="b-table w-100 sortable-table mt-0">
                    <thead>
                        <tr>
                            <th><span>{{ __('Name') }}</span></th>
                            <th><span>{{ __('Email') }}</span></th>
                            <th><span>{{ __('Last Modified') }}</span></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                        <tr>
                            <td>
                                <span>{{ $row->first_name.' '.$row->last_name }}</span>
                            </td>
                            <td>
                                <span>{{ $row->email }}</span>
                            </td>
                            <td>{{ date('d-M-y', strtotime($row->modified_at)) }}</td>
                            <td>
                                <a href="{{ url('settings/email-templates/'.$row->id) }}" class="btn btn-sm btn-primary js-view-template">{{ __('Edit') }}</a>
                                @if ($row->status == 'active')
                                <button class="btn btn-sm btn-danger js-change-status">{{ __('Deactivate') }}</button> 
                                @elseif ($row->status == 'inactive')
                                <button class="btn btn-sm btn-success js-change-status">{{ __('Activate') }}</button> 
                                @endif
                                
                                <button class="btn btn-sm btn-danger js-delete-user">{{ __('Delete') }}</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>   
             </div>
        </div>
    </div>
</div>
@endsection
