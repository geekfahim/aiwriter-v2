<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Update Tax Rate') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/tax-rates/edit/'.$tax->id) }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ $tax->name }}" class="form-control form-control-sm" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Type') }}</label>
                                <select name="type" class="form-control form-control-sm">
                                    <option value="">Select Here</option>
                                    <option value="inclusive" {{ $tax->type == 'inclusive' ? 'selected' : '' }}>Inclusive</option>
                                    <option value="exclusive" {{ $tax->type == 'exclusive' ? 'selected' : '' }}>Exclusive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label>{{ __('Percentage') }}</label>
                                <div class="input-group input-group-sm mb-3">
                                    <input type="text" class="form-control form-control-sm" name="percentage" value="{{ $tax->percentage }}" autocomplete="off">
                                    <span class="input-group-text">{{ __('%') }}</span>
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