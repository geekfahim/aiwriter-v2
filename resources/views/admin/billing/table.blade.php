<table class="b-table w-100 sortable-table ">
    <thead>
        <tr>
            <th>
                <span>{{ __('Customer Name') }}</span>
            </th>
            <th>
                <span>{{ __('Plan') }}</span>
            </th>
            <th>
                <span>{{ __('Amount') }}</span>
            </th>
            <th>
                <span>{{ __('Payment Method') }}</span>
            </th>
            <th>
                <span>{{ __('Billing Date') }}</span>
            </th>
            <th>
                <span>{{ __('Status') }}</span>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($rows as $row){?>
        <tr>
            <td class="text-capitalize">
                @if ($row->first_name || $row->last_name)
                    <span class="font-12">{{ $row->first_name.' '.$row->last_name }}</span>
                @else
                    <span class="font-12 border-bottom-dashed">{{ __('Not Set') }}</span>
                @endif
            </td>
            <td class="text-capitalize">
                <span>{{ DB::table('subscription_plans')->where('id', $row->plan_id)->first()->name; }}</span>
            </td>
            <td>
                <span class="font-12">{{ CurrencyHelper::format_with_currency($row->amount, $row->currency) }}</span>
            </td>
            <td>
                <span class="text-capitalize">{{ $row->processor }}</span>
            </td>
            <td>
                <span>{{ date('d-M-Y', strtotime($row->billing_date)) }}</span>
            </td>
            <td>
                <span class="badge bg-primary badge-sm text-capitalize">{{ $row->billing_status }}</span>
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