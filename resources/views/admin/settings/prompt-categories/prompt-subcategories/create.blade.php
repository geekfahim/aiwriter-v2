<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create SubCategory') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/prompt-sub-categories/add') }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <div class="small">
                        <label>{{ __('SubCategory Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-sm">
                    </div>
                    <div class="small">
                        <label>{{ __(' Select Category') }}</label>
                        
                        <select class="form-control form-control-sm" name="category_id">
                            <option value="" selected disabled > Choose Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" > {{ $category->category_name }}</option>
                            @endforeach
                        </select>
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