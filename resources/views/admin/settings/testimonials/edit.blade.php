<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Review') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/testimonials/edit/'.$review->id) }}" class="js-create-upload">
                @csrf
                <div class="modal-body">
                    <div class="pt-3 pb-3 row">
                        <div class="col-md-7">
                            <img class="image-fluid w-50 js-img-preview" src="{{ asset('uploads/brand/' . $review->image) }}" alt="Image">
                            <input type="file" class="d-none js-img-upload" name="image"/>
                        </div>
                        <div class="col-md-5">
                            <div class="float-end">
                                <button type="button" class="btn btn-sm btn-primary float-right mr-2" onclick="$('.js-img-upload').click();">{{ __('Change Image') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ $review->name }}">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label>{{ __('Review') }}</label>
                                <textarea name="review" class="form-control" cols="30" rows="5">{{ $review->review }}</textarea>
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