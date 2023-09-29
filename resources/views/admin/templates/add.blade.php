<div class="modal fade js-add-modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">{{ __('Create Template') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" class="js-add-form" action="{{ url('templates/add') }}">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group mt-3 col-md-12">
                        <label>{{ __('Name') }}</label>
                        <input type="text" class="form-control" name="name" autocomplete="off">
                    </div>
                    <div class="form-group mt-3 col-md-12">
                        <label>{{ __('Message') }}</label>
                        <textarea name="message" class="form-control" cols="30" rows="10"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
            </div>
            </form>
        </div>
    </div>
</div>