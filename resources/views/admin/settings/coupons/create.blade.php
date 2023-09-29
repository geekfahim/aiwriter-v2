<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Coupon') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/coupons/add') }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-sm" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Coupon Code') }}</label>
                                <input type="text" name="code" class="form-control form-control-sm" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Percentage Off') }}</label>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="text" class="form-control form-control-sm" name="percentage" autocomplete="off">
                                    <span class="input-group-text">{{ __('%') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label>{{ __('Qty') }}</label>
                                <input type="text" name="quantity" class="form-control form-control-sm" autocomplete="off">
                            </div>
                            <small>-1 for unlimited, 0 for none</small>
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