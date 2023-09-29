<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Subscription') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/subscriptions/edit/'.$subscription->user_id) }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Plan') }}</label>
                                <select name="plan" class="form-control">
                                    <option value="">{{ __('Select Here') }}</option>
                                    @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ $plan->id == $subscription->plan_id ? 'selected' : '' }}>{{ $plan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Billing Period') }}</label>
                                <select name="billing_period" class="form-control">
                                    <option value="">{{ __('Select Here') }}</option>
                                    <option value="month" {{ $subscription->plan_interval == 'month' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                                    <option value="year" {{ $subscription->plan_interval == 'year' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Start Date') }}</label>
                                <input type="datetime-local" name="start_date" class="form-control" value="{{ $subscription->created_at }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Recurring at') }}</label>
                                <input type="datetime-local" name="end_date" class="form-control" value="{{ $subscription->recurring_at }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Token') }}</label>
                                <input type="number" name="token" class="form-control" value="{{ $subscription->available_token }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <div class="mb-4">
                                <label>{{ __('Status') }}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{ __('Select Here') }}</option>
                                    <option value="active" {{ $subscription->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="inactive" {{ $subscription->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>