@extends('user.layout')
@section('content')
<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <h5 class="text-capitalize d-flex align-items-center">
        <div class="icon-bg bg-grey-light d-flex justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m14 2l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8m4 18V9h-5V4H6v16h12m-1-7v6H7l5-5l2 2m-4-5.5A1.5 1.5 0 0 1 8.5 12A1.5 1.5 0 0 1 7 10.5A1.5 1.5 0 0 1 8.5 9a1.5 1.5 0 0 1 1.5 1.5Z"></path></svg>
        </div>
        <div class="ms-2">
            {{ __('AI Image Generator') }}
        </div>
    </h5>
    <form method="POST" action="{{ url('image/' . $project->uuid) }}" class="js-image-form">
        @csrf
        <div class="border-bottom pb-4">
            <div class="row align-items-center">
            <div class="col-4">
                <input type="text" name="name" class="form-control form-control-sm form-control-shadow project-input" placeholder="{{ __('Image Name') }}" value="{{ $project->name }}" autocomplete="off">
            </div>
            <div class="col-8">
                <div class="float-end">
                    <a href="javascipt:void" class="small text-end font-xs">
                        {{ __('Generated Images') }} (<span class="saved-count">{{ $imageCount }}</span>)
                    </a>
                </div>
            </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 border-end">
                <div class="mb-5">
                    <div class="mt-5">
                        <label class="small sentence-case">{{ __('Image description') }}</label>
                        <textarea name="fields[description]" class="form-control form-control-sm form-control-shadow rounded project-input" placeholder="Description" cols="30" rows="5">{{ Helper::getArrayKey('description', json_decode($project->metadata, true)) }}</textarea>
                    </div>
                    <div class="mt-5 row">
                        <div class="col-md-4">
                            <label class="small">{{ __('Style') }}</label>
                            <select name="fields[style]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="" selected="">{{ __('None') }}</option>
                                @foreach(config('images.styles') as $key => $value)
                                    <option value="{{ $key }}" {{ Helper::getArrayKey('style', json_decode($project->metadata, true)) == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small">{{ __('Medium') }}</label>
                            <select name="fields[medium]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="" selected="">{{ __('None') }}</option>
                                @foreach(config('images.mediums') as $key => $value)
                                    <option value="{{ $key }}" {{ Helper::getArrayKey('medium', json_decode($project->metadata, true)) == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small">{{ __('Filter') }}</label>
                            <select name="fields[filter]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="" selected="">{{ __('None') }}</option>
                                @foreach(config('images.filters') as $key => $value)
                                    <option value="{{ $key }}" {{ Helper::getArrayKey('filter', json_decode($project->metadata, true)) == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-5 row">
                        <div class="col-md-12">
                            <label class="small">{{ __('Resolution') }}</label>
                            <select name="fields[resolution]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                @foreach(config('images.resolutions') as $key => $value)
                                    <option value="{{ $key }}"  {{ Helper::getArrayKey('resolution', json_decode($project->metadata, true)) ?? ($key == '512x512' ? 'selected' : '') }} {{ Helper::getArrayKey('resolution', json_decode($project->metadata, true)) == $key ? 'selected' : '' }}>{{ __($value) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-sm btn-dark w-100 js-generate-image" data-url="">{{ __('Generate Image') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 js-image-view">
                @include('user.image.view')
            </div>
        </div>
    </form>
</div>
@endsection