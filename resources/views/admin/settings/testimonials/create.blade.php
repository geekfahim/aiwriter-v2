<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Review') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/testimonials/add') }}" class="js-create-upload" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label>{{ __('Review') }}</label>
                                <textarea name="review" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div>
                                <button type="button" class="btn btn-sm btn-primary float-right mr-2" onclick="$('.js-img-upload').click();">{{ __('Upload Reviewer Image') }}</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <img class="image-fluid mt-3 w-50 js-img-preview d-none" src="" alt="Image">
                            <input type="file" class="d-none js-img-upload" name="image"/>
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