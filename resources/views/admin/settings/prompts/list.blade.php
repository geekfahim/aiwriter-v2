@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>{{ __('Prompt Templates') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('Ai Prompts') }}</p>
            </div>
            <div class="col-md-6 col-12 d-flex justify-content-end">
                <div class="pull-left-btn">
                    <a href="{{ route('import_prompt') }}" class="btn btn-secondary btn-md mt-1 float-end mx-1">
                        <span class="ion-plus">{{ 'Import Prompt' }}</span>
                    </a>
                </div>
                <div class="pull-right-btn">
                    <a href="{{ route('show_prompt') }}" class="btn btn-primary btn-md mt-1 float-end">
                        <span class="ion-plus">{{ 'Prompt List' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row justify-content-center">
            {{--  <div class="col-md-3">
                <div class="card ml-4 mt-6 menu-list border-0 rounded position-sticky top-125">
                    @include('admin.settings.nav')
                </div>        
            </div>  --}}
            <div class="col-md-10 mb-3">
                <div class="alert alert-danger ms-4 me-4 mt-3 mb-0 small d-none" role="alert">
                    <i class="fa fa-exclamation-triangle"></i> Some of the required fields are missing.
                </div>
                <div class="card mt-6 mr-10 border-0 p-4 mb-4">
                <form action="{{ url('admin/settings/prompts/add') }}" class="js-create-prompt my-5">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 small pt-2">
                            <label>{{ __('Template Name') }}<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control form-control-sm bg-white">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 small">
                                    <label>{{ __('Description') }}<span class="text-danger">*</span></label>
                                    <textarea name="main_description" class="form-control form-control-sm bg-white" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6 small">
                                <label>{{ __('Category') }}<span class="text-danger">*</span></label>
                                <select name="category" id="category" class="form-control form-control-sm text-capitalize bg-white">
                                    <option value="" selected disabled>choose</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6 small">
                                <label>{{ __('SubCategory') }}<span class="text-danger">*</span></label>
                                <select name="subcategory" id="subcategory" class="form-control form-control-sm text-capitalize bg-white"></select>
                            </div>
                                                        
                            <div class="mb-3 col-md-6 small">
                                <label>{{ __('Status') }}<span class="text-danger">*</span></label>
                                <select name="status" class="form-control form-control-sm bg-white">
                                    <option value="active">{{ __('Active') }}</option>
                                    <option value="inactive">{{ __('Inactive') }}</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-6 small">
                                <label>{{ __('Plan') }}<span class="text-danger">*</span></label>
                                <select name="plan" id="plan" class="form-control form-control-sm text-capitalize bg-white">
                                    <option value="" selected disabled>choose</option>
                                    @foreach ($SubscriptionPlan as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                                    @endforeach
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
                                                <input type="text" class="form-control form-control-sm bg-white" name="title[]">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 small">
                                                <label>{{ __('Field Type') }}<span class="text-danger">*</span></label>
                                                <select name="type[]" class="form-control form-control-sm bg-white mt-1">
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
                                            <input type="text" class="form-control form-control-sm bg-white" name="placeholder[]">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-4 small">
                                            <label>{{ __('AI Prompt') }}<span class="text-danger">*</span></label>
                                            <textarea name="description[]" class="form-control form-control-sm bg-white" cols="30" rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="input-fields-container">
                                <!-- Existing input fields will be here -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-md-12 mb-3">
     <div class="card mt-2 mr-10 border-0 p-4 mb-4">
         <div class="card-header py-0 content">Test Prompt</div>
         <div class="card-body p-0">
            @include('user.chat.chat')
            @include('user.chat.script')
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
                    <input type="text" class="form-control form-control-sm bg-white" name="title[]">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2 small">
                    <label>{{ __('Field Type') }}<span class="text-danger">*</span></label>
                    <select name="type[]" class="form-control form-control-sm bg-white">
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
                <input type="text" class="form-control form-control-sm bg-white" name="placeholder[]">
            </div>
        </div>
        <div class="row">
            <div class="mb-4 small">
                <label>{{ __('AI Prompt') }}<span class="text-danger">*</span></label>
                <textarea name="description[]" class="form-control form-control-sm bg-white" cols="30" rows="4"></textarea>
            </div>
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
                        $subcategorySelect.append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error); // Handle error if necessary
                }
            });
        }
    });
</script>


<div class="js-modal-view"></div>


@endsection
