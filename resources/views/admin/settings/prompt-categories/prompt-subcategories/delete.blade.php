<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Delete SubCategory') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/prompt-subcategories/delete/'.$subcategory->id) }}" class="js-create">
                @csrf
                <div class="modal-body border-bottom">
                    
                    <small><i class="fa fa-info-circle"></i> Do you want to delete SubCategory</small>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>