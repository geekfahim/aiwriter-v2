<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Customer') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/customers/add') }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('First Name') }}</label>
                                <input type="text" name="first_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Last Name') }}</label>
                                <input type="text" name="last_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label>{{ __('Email') }}</label>
                        <input type="text" name="email" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Password') }}</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Confirm Password') }}</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-4">
                        <label>{{ __('Select Plan') }}</label>
                        <select name="subscription_plan_id" class="form-select">
                            <option value="">{{ __('Select Here') }}</option>
                            @foreach ($subscription_plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="subscription-plan-settings d-none">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label>{{ __('Subscription Type') }}</label>
                                    <select name="subscription_type" class="form-select">
                                        <option value="month">{{ __('Monthly') }}</option>
                                        <option value="year">{{ __('Yearly') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label>{{ __('Amount') }}</label>
                                    <input type="text" name="amount" class="form-control">
                                </div>
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