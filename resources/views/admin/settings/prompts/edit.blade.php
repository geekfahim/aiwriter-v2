<div class="modal fade js-modal" id="js-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Prompt') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="alert alert-danger ms-4 me-4 mt-3 mb-0 small d-none" role="alert">
                <i class="fa fa-exclamation-triangle"></i> Some of the required fields are missing.
            </div>
            <form action="{{ url('admin/settings/prompts/edit/'.$prompt->id) }}" class="js-create-prompt">
                @csrf
                <div class="modal-body">
                    <div class="mb-3 small">
                        <label>{{ __('Template Name') }}<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-sm" value="{{ $prompt->name }}">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 small">
                                <label>{{ __('Description') }}<span class="text-danger">*</span></label>
                                <textarea name="main_description" class="form-control form-control-sm" cols="30" rows="3">{{ $prompt->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6 small">
                            <label>{{ __('Category') }}<span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-control form-control-sm text-capitalize">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $prompt->category == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-6 small">
                            <label>{{ __('SubCategory') }}<span class="text-danger">*</span></label>
                            <select name="subcategory" id="subcategory" class="form-control form-control-sm text-capitalize bg-white"></select>
                        </div>                        
                        <div class="mb-3 col-md-6 small">
                            <label>{{ __('Status') }}<span class="text-danger">*</span></label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="active" {{ $prompt->status == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                <option value="inactive" {{ $prompt->status == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6 small">
                            <label>{{ __('Plan') }}<span class="text-danger">*</span></label>
                            <select name="plan" class="form-control form-control-sm">
                                <option>{{ __('Choose') }}</option>
                                @if(count($plans)>0)
                                    @foreach($plans as $plan)
                                    <option value="{{$plan->id}}" {{ $prompt->plan_id == $plan->id ? 'selected' : '' }}>{{$plan->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="field-container">
                        @php
                            $string = $prompt->metadata;
                            $fields = json_decode($string, true);
                        @endphp
                        @foreach ($fields as $key => $field)
                        @if ($key == 'field_1')
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
                            <div class="collapse" id="collapseExample">
                                <div class="row small">
                                    <div class="col-md-6">
                                        <div class="mb-2">
                                            <label>{{ __('Title') }}<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm" name="title[]" value="{{ $field['title'] }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-2 small">
                                            <label>{{ __('Field Type') }}<span class="text-danger">*</span></label>
                                            <select name="type[]" class="form-control form-control-sm">
                                                <option value="">{{ __('Select Here') }}</option>
                                                <option value="input" {{ $field['type'] == 'input' ? 'selected' : '' }}>{{ __('Input') }}</option>
                                                <option value="textarea" {{ $field['type'] == 'textarea' ? 'selected' : '' }}>{{ __('Textarea') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 small">
                                        <label>{{ __('Placeholder') }}</label>
                                        <input type="text" class="form-control form-control-sm" name="placeholder[]" value="{{ $field['placeholder'] }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-4 small">
                                        <label>{{ __('AI Prompt') }}<span class="text-danger">*</span></label>
                                        <textarea name="description[]" class="form-control form-control-sm" cols="30" rows="4">{{ $field['description'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                        <div id="input-fields-container">
                            @php
                                $counter = 2;
                            @endphp
                            @foreach ($fields as $key => $field)
                            @if ($key != 'field_1')
                            <div>
                                <div class="border-bottom mb-3 row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ url('images/icons/caret-right-fill.svg') }}" class="me-2">
                                            <h5 class="small mb-0 collapse-btn" role="button" data-bs-toggle="collapse" data-bs-target="#collapseExample{{ $counter }}">
                                                Input Field {{ $counter }}
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
                                <div class="collapse" id="collapseExample{{ $counter }}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2 small">
                                                <label>{{ __('Title') }}<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm" name="title[]" value="{{ $field['title'] }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 small">
                                                <label>{{ __('Field Type') }}<span class="text-danger">*</span></label>
                                                <select name="type[]" class="form-control form-control-sm">
                                                    <option value="">{{ __('Select Here') }}</option>
                                                    <option value="input" {{ $field['type'] == 'input' ? 'selected' : '' }}>{{ __('Input') }}</option>
                                                    <option value="textarea" {{ $field['type'] == 'textarea' ? 'selected' : '' }}>{{ __('Textarea') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-2 small">
                                            <label>{{ __('Placeholder') }}</label>
                                            <input type="text" class="form-control form-control-sm" name="placeholder[]" value="{{ $field['placeholder'] }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-4 small">
                                            <label>{{ __('AI Prompt') }}<span class="text-danger">*</span></label>
                                            <textarea name="description[]" class="form-control form-control-sm" cols="30" rows="4">{{ $field['description'] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $counter++; @endphp
                            @endif
                            @endforeach
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Get references to the category and subcategory select elements
            const $categorySelect = $('#category');
            const $subcategorySelect = $('#subcategory');
    
            // Attach an event listener to the category select element
            $categorySelect.on('change', function() {
                populateSubcategories();
            });
    
            // Call the populateSubcategories function initially to populate subcategories based on the default selected category (if any)
            populateSubcategories();
    
            function populateSubcategories() {
                // Clear the subcategory select element
                $subcategorySelect.empty();
    
                // Get the selected category's ID
                const categoryId = $categorySelect.val();
    
                // AJAX request to fetch the subcategories based on the selected category
                $.ajax({
                    url: '/admin/getSubcategories', // Replace with the actual route URL that fetches subcategories based on category ID
                    type: 'GET',
                    data: {
                        category_id: categoryId
                    },
                    success: function(response) {
                        // Populate the subcategory select element with the fetched subcategories
                        response.subcategories.forEach(function(subcategory) {
                            const $option = $('<option>', {
                                value: subcategory.id,
                                text: subcategory.name,
                                selected: '{{ $prompt->subcategory }}' == subcategory.id // Check if the subcategory ID matches the selected subcategory
                            });
                        
                            $subcategorySelect.append($option);
                        });
                        
                    },
                    error: function(xhr, status, error) {
                        console.log(error); // Handle error if necessary
                    }
                });
            }
        });
    </script>
    
    
</div>