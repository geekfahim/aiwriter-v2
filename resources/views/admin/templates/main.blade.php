@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('Templates') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('templates') }}</p>
            </div>
            <div class="col-md-6">
                <div class="pull-right-btn">
                    <button type="button" class="btn btn-primary btn-md mt-1 float-end js-add" data-url="{{ url('templates/add') }}" title="New Template">
                        <span class="ion-plus">{{ __('Create Template') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="main-body">
        <div class="row">
            <div class="minimal-view-col-1 col-md-12  pe-0 mt-4 h-100">
                <div class="h-100 pt-3 scrollbox overflow-y-auto" id="table-render">
                    <table class="b-table w-100 sortable-table ">
                        <thead>
                            <tr>
                                <th>
                                    <div class="input-checkbox">
                                        <input type="checkbox" class="chbx-all" name="checkbox" id="checkbox-1">
                                        <label for="checkbox-1"></label>
                                    </div>
                                </th>
                                <th data-sort-column="full_name" data-sort="" class="sortable" role="button">
                                    <span>{{ __('Template Name') }}</span>
                                </th>
                                <th data-sort-column="company_name" data-sort="" class="sortable" role="button">
                                    <span>{{ __('Message') }}</span>
                                </th>
                                <th data-sort-column="phone_number" data-sort="" class="sortable" role="button">
                                    <span>{{ __('Status') }}</span>
                                </th>
                                <th data-sort-column="balance" data-sort="" class="sortable" role="button">
                                    <span>{{ __('Last Modified') }}</span>
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rows as $row){?>
                            <tr>
                                <td>
                                    <div class="input-checkbox">
                                        <input type="checkbox" class="i-check" name="products" value="2" data-value="2" id="checkbox-2" onclick="selectCheckbox(this)">
                                        <label for="checkbox-2"></label>
                                    </div>
                                </td>
                                <td class="text-capitalize">
                                    <span class="font-12">{{ $row->name }}</span>
                                </td>
                                <td class="text-capitalize">
                                    <span>{{ $row->message }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-primary badge-sm text-capitalize">{{ $row->status }}</span>
                                </td>
                                <td>
                                    <span>{{ date('d-M-Y', strtotime($row->modified_at)) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="dropdown">
                                            <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v fa-xs"></i>
                                            </span>
                                            <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="">{{ __('Edit') }}</a></li>
                                                <li><a class="dropdown-item" href="">{{ __('Deactivate') }}</a></li>
                                                <li><a class="dropdown-item border-top delete-product" href="javascript:void()" data-url="">{{ __('Delete') }}</a></li>
                                            </ul>
                                        </div> 
                                    </div>
                                </td>
                            </tr>
                            <?php }?>
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
</div>
<div class="js-add-view"></div>
@endsection
