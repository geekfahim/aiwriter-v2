<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Create Prompt') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger ms-4 me-4 mt-3 mb-0 small d-none" role="alert">
                <i class="fa fa-exclamation-triangle"></i> Some of the required fields are missing.
            </div>
            <form action="{{ url('admin/settings/prompts/add') }}" class="js-create-prompt">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 small">
                        <label>{{ __('Template Name') }}<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 small">
                                <label>{{ __('Description') }}<span class="text-danger">*</span></label>
                                <textarea name="main_description" class="form-control form-control-sm" cols="30" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6 small">
                            <label>{{ __('Category') }}<span class="text-danger">*</span></label>
                            <select name="category" class="form-control form-control-sm text-capitalize">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6 small">
                            <label>{{ __('Status') }}<span class="text-danger">*</span></label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="active">{{ __('Active') }}</option>
                                <option value="inactive">{{ __('Inactive') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="field-container">
                        <div class="parent-field">
                            <div class="border-bottom border-top mt-3 pt-3 mb-3 d-flex header-field-ct">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ url('images/icons/caret-right-fill.svg') }}" class="me-2">
                                        <h5 class="small mb-0 collapse-btn" role="button" data-bs-toggle="collapse" data-bs-target="#collapseExample">
                                            {{ __('Input Field 1') }}
                                        </h5>
                                    </div>
                                    <small class="ms-1"><i class="fa fa-info-circle"></i> {{ __('input field details for the prompt.') }}</small>
                                </div>
                                <div class="col-md-6">
                                    <span class="float-end btn btn-primary btn-sm add-field">
                                        {{ __('Add Field') }}
                                    </span>
                                </div>
                            </div>
                            <div class="collapse show" id="collapseExample">
                                <div class="row small">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label>{{ __('Title') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="title[]">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 small">
                                            <label>{{ __('Field Type') }}<span class="text-danger">*</span></label>
                                            <select name="type[]" class="form-control form-control-sm">
                                                <option value="">{{ __('Select Here') }}</option>
                                                <option value="input">{{ __('Input') }}</option>
                                                <option value="textarea">{{ __('Textarea') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 small">
                                        <label>{{ __('Placeholder') }}</label>
                                        <input type="text" class="form-control form-control-sm" name="placeholder[]">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 small">
                                        <label>{{ __('AI Prompt') }}<span class="text-danger">*</span></label>
                                        <textarea name="description[]" class="form-control form-control-sm" cols="30" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="input-fields-container">
                            <!-- Existing input fields will be here -->
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
<div class="d-none" id="input-field-template">
    <div class="border-bottom mb-3 row">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <img src="{{ url('images/icons/caret-right-fill.svg') }}" class="me-2">
                <h5 class="small mb-0 collapse-btn" role="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2">
                    Input Field 2
                </h5>
            </div>
            <small class="ms-1"><i class="fa fa-info-circle"></i> {{ __('input field details for the prompt.') }}</small>
        </div>
        <div class="col-md-6">
            <span class="float-end remove-field">
                <img src="{{ url('images/icons/delete.svg') }}">
            </span>
        </div>
    </div>
    <div class="collapse" id="collapseExample2">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-2 small">
                    <label>{{ __('Title') }}<span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" name="title[]">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2 small">
                    <label>{{ __('Field Type') }}<span class="text-danger">*</span></label>
                    <select name="type[]" class="form-control form-control-sm">
                        <option value="">{{ __('Select Here') }}</option>
                        <option value="input">{{ __('Input') }}</option>
                        <option value="textarea">{{ __('Textarea') }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-2 small">
                <label>{{ __('Placeholder') }}</label>
                <input type="text" class="form-control form-control-sm" name="placeholder[]">
            </div>
        </div>
        <div class="row">
            <div class="mb-4 small">
                <label>{{ __('AI Prompt') }}<span class="text-danger">*</span></label>
                <textarea name="description[]" class="form-control form-control-sm" cols="30" rows="4"></textarea>
            </div>
        </div>
    </div>
</div>