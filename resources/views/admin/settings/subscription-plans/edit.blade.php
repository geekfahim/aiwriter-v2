<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Plan') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/plans/edit/'.$plan->id) }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <span class="divider-start fs-4 fw-bold text-dark mb-2">Plan Details</span>
                    <div class="mb-4">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" value="{{ $plan->name }}" class="form-control form-control-sm" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label>{{ __('Description') }}</label>
                                <textarea name="description" class="form-control form-control-sm" cols="30" rows="3">{{ $plan->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label><small>{{ __('Monthly Price') }} ({{ Helper::config('currency') }})</small></label>
                                <input type="text" class="form-control form-control-sm" name="monthly_price" value="{{ CurrencyHelper::format_number($plan->monthly_price) }}" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label><small>{{ __('Yearly Price') }} ({{ Helper::config('currency') }})</small></label>
                                <input type="text" class="form-control form-control-sm" name="yearly_price" value="{{ CurrencyHelper::format_number($plan->yearly_price) }}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <span class="divider-start fs-4 text-dark mb-2">Features</span>
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Words Limit') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="words" value="{{ $plan->words }}" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Image Count') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="image_count" value="{{ $plan->image_count }}" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Text to Speech Minutes') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="minutes" value="{{ $plan->minutes }}" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('File Size Limit (MB)') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="file_size" value="{{ $plan->file_size }}" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Monthly Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="monthly_token" value="{{ $plan->monthly_token }}" autocomplete="off">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Yearly Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="yearly_token" value="{{ $plan->yearly_token }}" autocomplete="off">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Trial Period Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="trial_token" autocomplete="off" value="{{ $plan->trial_token }}" placeholder="0">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Editional Price Per Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="editional_token_price" value="{{ $plan->editional_token_price }}" autocomplete="off" placeholder="0.00">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        {{-- <div class="col-md-6 mb-5">
                            <label><small>{{ __('No Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="max_credit" value="{{ $plan->no_token }}" autocomplete="off">
                        </div> --}}
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4 px-0">
                                <input type="checkbox" class="form-check-input mx-0" name="max_promt_timeline" value="1" id="max_promt_timeline" {{ $plan->yearly_access ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="max_promt_timeline">Yearly</label><br>
                                <small><i class="fa fa-info-circle"></i> {{ __('Max Prompt Access (Leave for Monthly).') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4">
                                <input type="checkbox" class="form-check-input" name="allow_export" value="1" id="formSwitch1" {{ $plan->allow_export ? 'checked' : '' }}>
                                <label class="form-check-label" for="formSwitch1">Export as Word/PDF</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4">
                                <input type="checkbox" class="form-check-input" name="allow_copy" value="1" id="formSwitch2" {{ $plan->allow_copy ? 'checked' : '' }}>
                                <label class="form-check-label" for="formSwitch2">copy to clipboard</label>
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