<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create Plan') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('admin/settings/plans/add') }}" class="js-create">
                @csrf
                <div class="modal-body">
                    <span class="divider-start fs-4 text-dark mb-2">Plan Details</span>
                    <div class="mb-4">
                        <label>{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-sm" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label>{{ __('Description') }}</label>
                                <textarea name="description" class="form-control form-control-sm" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label><small>{{ __('Monthly Price') }} ({{ Helper::config('currency') }})</small></label>
                                <input type="text" class="form-control form-control-sm" name="monthly_price" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label><small>{{ __('Yearly Price') }} ({{ Helper::config('currency') }})</small></label>
                                <input type="text" class="form-control form-control-sm" name="yearly_price" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <span class="divider-start fs-4 text-dark mb-2">Features</span>
                    <div class="row">
                        <div class="mb-5 col-md-6">
                            <label>{{ __('Words Limit') }}</label>
                            <input type="text" class="form-control form-control-sm" name="words" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited words.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Image Count') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="image_count" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Text to Speech Minutes') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="minutes" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('File Size Limit (MB)') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="file_size" autocomplete="off">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Monthly Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="monthly_token" autocomplete="off">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Yearly Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="yearly_token" autocomplete="off">
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Trial Period Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="trial_token" autocomplete="off" placeholder="0">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label><small>{{ __('Editional Price Per Token') }}</small></label>
                            <input type="text" class="form-control form-control-sm" name="editional_token_price" autocomplete="off" placeholder="0.00">
                            <small><i class="fa fa-info-circle"></i> {{ __('Leave empty for unlimited.') }}</small>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4 px-0">
                                <label><small> </small></label><br>
                                <input type="checkbox" class="form-check-input mx-0" name="prompt_type" value="0" id="prompt_type">
                                <label class="form-check-label ms-2" for="prompt_type">Free</label><br>
                                <small><i class="fa fa-info-circle"></i> {{ __('Prompt Type Leave for paid.') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4">
                                <input type="checkbox" class="form-check-input" name="allow_export" value="1" id="formSwitch1">
                                <label class="form-check-label" for="formSwitch1">Export as word/pdf</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4">
                                <input type="checkbox" class="form-check-input" name="allow_copy" value="1" id="formSwitch2">
                                <label class="form-check-label" for="formSwitch2">copy to clipboard</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-4 px-0">
                                <input type="checkbox" class="form-check-input mx-0" name="max_promt_timeline" value="1" id="max_promt_timeline">
                                <label class="form-check-label ms-2" for="max_promt_timeline">Yearly</label><br>
                                <small><i class="fa fa-info-circle"></i> {{ __('Max Prompt Access (Leave for Monthly).') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <small id="tempErr" class="text-warning"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" id="saveBtn" class="btn btn-primary">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('input[name="prompt_type"]').change(function(){
        if ($(this).is(':checked')) {
           $.ajax({
                url:"{{route('prompt.plan.check')}}",
                method:'get',
                success:function(res){
                    if(res.success===true){
                        $('#tempErr').html(res.message);
                        $('#saveBtn').attr('disabled', 'true');
                    }else{
                        $('#tempErr').html('');
                        $('#saveBtn').removeAttr('disabled');

                    }
                }
            });
        }else{
            $('#tempErr').html('');
            $('#saveBtn').removeAttr('disabled');

        }
    });
</script>