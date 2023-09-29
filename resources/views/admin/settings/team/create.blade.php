<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add User') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/team/add') }}" class="js-create">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>