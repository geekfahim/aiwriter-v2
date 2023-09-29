@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>{{ __('Prompt Templates') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> <span class="text-grey">{{ __('Ai Prompts') }}</span><i class="fa fa-angle-right fa-fw"></i> {{ __('category-list') }}</p>
            </div>
            <div class="col-md-6 col-12">
                <div class="pull-right-btn">
                    <button type="button" class="btn btn-primary btn-md mt-1 float-end js-add" data-url="{{ url('admin/settings/prompt-sub-categories/add') }}">
                        <span class="ion-plus">{{ 'Create SubCategory' }}</span>
                    </button>
                    <a href="{{ url('admin/settings/prompt-categories') }}" type="button" class="btn btn-primary btn-md mt-1 float-end me-2">
                        <span class="ion-plus">{{ 'Back' }}</span>
                    </a>
                </div>
    
               
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row">
            <div class="col-md-12">
                <table class="b-table w-100 sortable-table mt-4">
                    <thead>
                        <tr>
                            <th>
                                <span>{{ __('Category Name') }}</span>
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
                                <a href="{{ route('subcategory_list',$row->id) }}" style="color:#000;><span class="text-capitalize">{{ $row->category_name }}</span></a>
                            </td>
                            <td>{{ date('d-M-y', strtotime($row->updated_at)) }}</td>
                            <td>
                                <div class="d-flex">
                                    <div class="dropdown">
                                        <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-xs"></i>
                                        </span>
                                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton1">
                                            <li><button type="button" class="dropdown-item js-edit" data-url="{{ url('admin/settings/prompt-categories/edit/'.$row->id) }}">{{ __('Edit') }}</button></li>
                                            <li><button type="button" class="dropdown-item border-top js-edit" data-url="{{ url('admin/settings/prompt-categories/delete/'.$row->id) }}">{{ __('Delete') }}</button></li>
                                        </ul>
                                    </div> 
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> 
                <div class="d-flex fs-7 float-end mt-4">
                    <nav>
                        {{  $rows->links('pagination::bootstrap-4')  }}
                    </nav>
                </div>  
             </div>
        </div>
    </div>
</div>
<div class="js-modal-view"></div>
@endsection
