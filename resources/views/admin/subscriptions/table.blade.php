<table class="b-table w-100 sortable-table ">
    <thead>
        <tr>
            <th>
                <span>{{ __('Subscription ID') }}</span>
            </th>
            <th>
                <span>{{ __('Customer Name') }}</span>
            </th>
            <th>
                <span>{{ __('Plan') }}</span>
            </th>
            <th>
                <span>{{ __('Token') }}</span>
            </th>
            <th>
                <span>{{ __('Subscription Period') }}</span>
            </th>
            <th>
                <span>{{ __('Status') }}</span>
            </th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
        <tr>
            <td class="text-capitalize">
                <span class="font-12">#{{ $row->id }}</span>
            </td>
            <td class="text-capitalize">
                <span>{{ $row->user->first_name.' '.$row->user->last_name }}</span>
            </td>
            <td>
                <span class="font-12">{{ $row->plan_id == 0 ? __('Not Set') : $row->plan->name }}</span>
            </td>
            <td>
                <span class="font-12  p-2 text-light rounded @if($row->available_token<10) bg-danger @elseif($row->available_token<50) bg-warning @else bg-success @endif">{{ $row->available_token }}</span>
            </td>
            <td>
                <div class="row">
                    <div class="col-5">
                        <span>{{ $row->created_at == NULL ? __('Not Set') : date('d M Y H:i', strtotime($row->created_at)) }}</span>
                    </div>
                    <div class="col-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13.3 17.275q-.3-.3-.288-.725t.313-.725L16.15 13H5q-.425 0-.713-.288T4 12q0-.425.288-.713T5 11h11.15L13.3 8.15q-.3-.3-.3-.713t.3-.712q.3-.3.713-.3t.712.3L19.3 11.3q.15.15.213.325t.062.375q0 .2-.063.375t-.212.325l-4.6 4.6q-.275.275-.687.275t-.713-.3Z"/></svg>
                    </div>
                    <div class="col-5">
                        <span>{{ $row->recurring_at == NULL ? __('Not Set') : date('d M Y H:i', strtotime($row->recurring_at)) }}</span>
                    </div>
                </div>
            </td>
            <td>
                <span class="text-capitalize">{{ $row->status }}</span>
            </td>
            <td>
                <div class="d-flex">
                    <div class="dropdown">
                        <span type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-xs"></i>
                        </span>
                        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="dropdownMenuButton1">
                            <li><button type="button" class="dropdown-item js-edit" data-url="{{ url('admin/subscriptions/edit/'.$row->user_id) }}">{{ __('Edit') }}</button></li>
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