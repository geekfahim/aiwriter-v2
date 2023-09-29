<div class="table-responsive-sm">
    <table class="b-table sortable-table w-100">
        <thead>
            <tr>
                <th data-sort-column="full_name" data-sort="" class="sortable" role="button">
                    <span>{{ __('Name') }}</span>
                </th>
                <th data-sort-column="company_name" data-sort="" class="sortable" role="button">
                    <span>{{ __('Email') }}</span>
                </th>
                <th data-sort-column="email" data-sort="" class="sortable" role="button">
                    <span>{{ __('Plan') }}</span>
                </th>
                <th data-sort-column="phone_number" data-sort="" class="sortable" role="button">
                    <span>{{ __('Status') }}</span>
                </th>
                <th data-sort-column="balance" data-sort="" class="sortable" role="button">
                    <span>{{ __('Date Joined') }}</span>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
            <tr>
                <td class="text-capitalize">
                    @if ($row->first_name || $row->last_name)
                        <span class="font-12">{{ $row->first_name.' '.$row->last_name }}</span>
                    @else
                        <span class="font-12 border-bottom-dashed">{{ __('Not Set') }}</span>
                    @endif
                </td>
                <td>
                    <span>{{ $row->email }}</span>
                </td>
                <td>
                    @if ($row->subscription != null && $row->subscription->plan_id != null)
                        <span class="font-12">{{ $row->subscription->plan->name }}</span>
                    @else
                        <span class="font-12">{{ __('Not Set') }}</span>
                    @endif
                </td>
                <td>
                    <span class="badge bg-primary badge-sm text-capitalize">{{ $row->status }}</span>
                </td>
                <td>
                    <span>{{ date('d-M-Y', strtotime($row->created_at)) }}</span>
                </td>
                <td>
                    <div class="d-flex">
                        <div class="dropdown">
                            <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-xs"></i>
                            </span>
                            <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton1">
                                <li><button type="button" class="dropdown-item js-edit" data-url="{{ url('admin/customers/edit/'.$row->id) }}">{{ __('Edit') }}</button></li>
                                @if ($row->status == 'active')
                                <li><button type="button" class="dropdown-item js-change-status" data-url="{{ url('admin/customers/deactivate/'.$row->id) }}" data-message="{{ __('Please confirm that you want to deactivate this user. They will not be able to login to their accounts.') }}">{{ __('Deactivate') }}</button></li>
                                @elseif ($row->status == 'inactive')
                                <li><button type="button" class="dropdown-item js-change-status" data-url="{{ url('admin/customers/activate/'.$row->id) }}" data-message="{{ __('Please confirm that you want to activate this user.') }}">{{ __('Activate') }}</button></li>
                                @endif
                                <li><button type="button" class="dropdown-item border-top js-change-status" data-url="{{ url('admin/customers/delete/'.$row->id) }}" data-message="{{ __('Please confirm that you want to delete this user. This action can\'t be undone.') }}">{{ __('Delete') }}</button></li>
                            </ul>
                        </div> 
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex fs-7 float-end mt-4">
    <nav>
        {{  $rows->links('pagination::bootstrap-4')  }}
    </nav>
</div>