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
                <table class="b-table w-100 sortable-table mt-6">
                    <thead>
                        <tr>
                            <th>
                                <span>{{ __('Pages') }}</span>
                            </th>
                            <th>
                                <span>{{ __('Last Modified') }}</span>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $row)
                        <tr>
                            <td>
                                <span>{{ $row->title }}</span>
                            </td>
                            <td>{{ date('d-M-y', strtotime($row->updated_at)) }}</td>
                            <td>
                                <a href="{{ url('admin/settings/pages/edit/'.$row->id) }}" class="btn btn-sm btn-primary js-view-template">{{ __('Edit') }}</a>
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
