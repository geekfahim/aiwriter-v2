<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete Category') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/prompt-categories/delete/'.$category->id) }}" class="js-create">
                @csrf
                <div class="modal-body border-bottom">
                    <div class="small mb-4">
                        <label>{{ __('Select the category where all templates will be reverted to') }}</label>
                        <select name="category" class="form-control form-control-sm text-capitalize">
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option> 
                            @endforeach
                        </select>
                    </div>

                    <small><i class="fa fa-info-circle"></i> This action can't be undone.</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>