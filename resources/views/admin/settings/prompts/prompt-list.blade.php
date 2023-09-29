@extends('admin.layout')
@section('content')
<!-- Page content -->
<style>
    .dataTables_paginate,.dataTables_length,.dataTables_info {
        display:none;
    }
    #prompt_table_filter{
        margin-top: -42px;
    }
</style>
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>{{ __('Prompt Templates') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> <span class="text-grey">{{ __('Ai Prompts') }}</span><i class="fa fa-angle-right fa-fw"></i> {{ __('prompt-list') }}</p>
            </div>
            <div class="col-md-6 col-12">
                <div class="pull-right-btn">
                    <a href="{{ url('admin/settings/prompts') }}" class="btn btn-primary btn-md mt-1 float-end">
                        <span class="ion-plus">{{ 'Back' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="row justify-content-start">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="bulk_action">Bulk Action</label>
                            <div class="d-flex">
                                <select class="form-control" name="bulk_action" id="bulk_action">
                                    <option selected>Select</option>
                                    <option value="delete_selected">Delete Selected</option>
                                </select>
                                <span class="btn btn-primary mx-1" onclick="actionNow()">Action</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-12">
                <table class="b-table w-100 sortable-table mt-6 table-sm small" id="prompt_table">
                    <thead>
                        <tr>
                            <th>
                                <div class="d-flex">
                                    <span><input class="form-control-sm" type="checkbox" id="selectAll"></span>
                                    <span class="p-1 mx-1">{{ __('All') }}</span>
                                </div>
                            </th>
                            <th>
                                <span> {{ __('Subscription Plan') }} </span>
                            </th>
                            <th>
                                <span>{{ __('Name') }}</span>
                            </th>
                            <th>
                                <span>{{ __('Category') }}</span>
                            </th>
                            <th>
                                <span>{{ __('SubCategory') }}</span>
                            </th>
                            <th>
                                <span>{{ __('Last Modified') }}</span>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="search">
                        @foreach ($rows as $row)
                        <tr>
                            <td>
                                <span><input class="form-control-sm" name="selectPromt[]" type="checkbox" value="{{$row->id}}"></span>
                            </td>
                            <td>
                                <span class="text-capitalize">{{ $row->plan_id != 0 ? $row->plan->name : 'Free Plan'}}</span>
                            </td>
                            <td>
                                <span class="text-capitalize">{{ $row->name }}</span>
                                <br>
                                <small class="text-muted">{{ $row->description }}</small>
                            </td>
                            <td>
                                <span class="text-capitalize">{{ $row->category != 0 ? $row->templateCategory->category_name : 'Freestyle'}}</span>
                            </td>
                            <td>
                                <span class="text-capitalize">{{ $row->subcategory != 0 ? $row->subCategory->name : 'Freestyle'}}</span>
                            </td>
                            <td>{{ date('d-M-y', strtotime($row->updated_at)) }}</td>
                            <td>
                                <div class="d-flex">
                                    <div class="dropdown">
                                        <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-xs"></i>
                                        </span>
                                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton1">
                                            <li><button type="button" class="dropdown-item js-edit" data-url="{{ url('admin/settings/prompts/edit/'.$row->id) }}">{{ __('Edit') }}</button></li>
                                            <li><button type="button" class="dropdown-item border-top js-change-status" data-url="{{ url('admin/settings/prompts/delete/'.$row->id) }}" data-message="{{ __('Please confirm that you want to delete this row. This action can\'t be undone.') }}">{{ __('Delete') }}</button></li>
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
                        {{ $rows->links('pagination::bootstrap-4')  }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (){
        $('#prompt_table').DataTable();
        $('#prompt_table_filter').find('input').removeClass('form-control-sm');
    });
    
    
   $(document).ready(function() {
        // Select/deselect all checkboxes when the "selectAll" checkbox is clicked
        $('#selectAll').click(function() {
            var isChecked = $(this).prop('checked');
            $('input[name="selectPromt[]"]').prop('checked', isChecked);
        });
    
        // Check if at least one checkbox is checked
        $('input[name="selectPromt[]"]').change(function() {
            var totalCheckboxes = $('input[name="selectPromt[]"]').length;
            var checkedCount = $('input[name="selectPromt[]"]:checked').length;
            $('#selectAll').prop('checked', totalCheckboxes === checkedCount);
        });
    });

    function actionNow(){
        
        var bulk_action = $('#bulk_action').val();
        if(bulk_action=='delete_selected'){
                // Check if at least one checkbox is checked
            if ($('input[name="selectPromt[]"]:checked').length > 0) {
                
                var selectedItems = [];
    
                // Get the values of all selected checkboxes
                $('input[name="selectPromt[]"]:checked').each(function() {
                    selectedItems.push($(this).val());
                });
       
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                
                $.ajax({
                    url:"{{route('prompt.bulk.delete')}}",
                    method:'post',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data:{id:selectedItems},
                    beforeSend:function(){
                        return confirm("Are You Sure?");
                    },
                    success:function(res){
                        if(res.success===true){
                            window.location="";
                        }else{
                            alert("Something Went Wrong.");
                        }
                    }
                });
            }else{
                alert("Select at least one item.");
            }
        }else{
            alert("Please Select Option.");
        }
    }
    
    // function fetch_search_data(query = '') {
    //     if (!query) {
    //         $('.search').html('');
    //         return;
    //     }
    //     var csrfToken = '{{ csrf_token() }}';
    //     $.ajax({
    //         url: "{{ route('prompt_search') }}"
    //         , method: 'POST'
    //         , headers: {
    //             'X-CSRF-Token': csrfToken
    //         }
    //         , data: {
    //             query: query
    //         , }
    //         , dataType: 'json'
    //         , success: function(data) {
    //             var less = `<tr>
    //                 <td>
    //                     No Data found
    //                 </td>
    //             </tr>`;
    //             var html = '';
    //             if (data.length > 0) {
    //                 data.forEach((row) => {
    //                     html += `<tr>
    //                         <td>
    //                             <span class="text-capitalize">${row.name}</span>
    //                             <br>
    //                             <small class="text-muted">${row.description}</small>
    //                         </td>
    //                         <td>
    //                             <span class="text-capitalize">${row.category != 0 ? row.category_new.category_name : 'Freestyle'}</span>
    //                         </td>
    //                         <td>
    //                             <span class="text-capitalize">${row.subcategory != 0 ? row.subCategory : 'Freestyle Sub'}</span>
    //                         </td>
    //                         <td>${new Date(row.updated_at).toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' })}</td>
    //                         <td>
    //                             <div class="d-flex">
    //                                 <div class="dropdown">
    //                                     <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    //                                         <i class="fas fa-ellipsis-v fa-xs"></i>
    //                                     </span>
    //                                     <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton1">
    //                                         <li><button type="button" class="dropdown-item js-edit" data-url="/admin/settings/prompts/edit/${row.id}">{{ __('Edit') }}</button></li>
    //                                         <li><button type="button" class="dropdown-item js-edit" data-url="/admin/settings/prompts/delete/${row.id}">{{ __('Delete') }}</button></li>
                                            
                                            
    //                                      </ul>
    //                                 </div>
    //                             </div>
    //                         </td>
    //                     </tr>`;
    //                 });
    //             } else {
    //                 html = less;
    //             }
    //             $('.search').html(html);
    //         }
    //     });
    // }

</script>

<div class="js-modal-view"></div>






@endsection
