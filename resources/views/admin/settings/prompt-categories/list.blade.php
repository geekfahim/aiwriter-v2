@extends('admin.layout')
@section('content')
<!-- Page content -->
<div class="content">
    <div class="main-header p-3">
        <div class="row">
            <div class="col-md-6 col-12">
                <h3>{{ __('Prompt Templates Categories') }}</h3>
                <p class="mt-2 text-capitalize"><span class="text-grey">{{ __('common.dashboard') }}</span> <i class="fa fa-angle-right fa-fw"></i> {{ __('Ai Prompts') }}</p>
            </div>
            <div class="col-md-6 col-12">
                <div class="pull-right-btn">
                    <a href="{{ route('list_cat') }}" class="btn btn-primary btn-md mt-1 float-end">
                        <span class="ion-plus">{{ 'Category List' }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="main-body p-3">
        <div class="row d-flex justify-content-center">
            {{--  <div class="col-md-3">
                <div class="card ml-4 mt-6 menu-list border-0 rounded position-sticky top-125">
                    @include('admin.settings.nav')
                </div>        
            </div>  --}}
            <div class="col-md-8 col-12">
                <div class="card mt-6 mr-10 border-0 p-4 mb-4">
                <h3 class="text-center mt-3">Create New Category</h3> <!-- Added text here -->
                <form action="{{ url('admin/settings/prompt-categories/add') }}" class="js-create my-5">
                    @csrf
                    <div class="modal-body">
                        <div class="small">
                            <label class="my-2">{{ __('Category Name') }}</label>
                            <input type="text" name="name" class="form-control form-control-sm py-3 bg-white">
                        </div>
                    </div>
                    <div class="modal-footer my-3">
                        <div class="col-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">{{ __('Save changes') }}</button>
                        </div>
                    </div>
                </form>
                </div> 
            </div>
            
        </div>
    </div>
</div>
<div class="js-modal-view"></div>
@endsection
