@extends('user.layout')
@section('content')
<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <h5 class="text-capitalize">{{ $project->category->name }}</h5>
    <div class="border-bottom pb-4">
        <div class="row align-items-center">
          <div class="col-4">
            <form action="{{ url('project/'.$project->uuid.'/edit') }}">
                @csrf
                <input type="text" name="name" class="form-control form-control-sm form-control-shadow project-input" value="{{ $project->name }}">
            </form>
          </div>
          <div class="col-8">
            <div class="float-end">
                <div class="d-flex">
                    <a href="javascipt:void" class="small tex-end me-5 mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m12 21.35l-1.45-1.32C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5c0 3.77-3.4 6.86-8.55 11.53L12 21.35Z"/></svg>
                        {{ __('Saved') }} (<span class="saved-count">{{ $saved_count }}</span>)
                    </a>
                    @if (Helper::is_trial_mode() || Helper::subscription()->plan->allow_export == 1)
                    <div class="dropdown">
                        <button class="btn btn-sm btn-dark text-white w-100 border-0 dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ __('Export As') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="{{ url('project/export/'.$project->uuid.'/word') }}" class="dropdown-item">{{ __('Word') }}</a>
                            <a href="{{ url('project/export/'.$project->uuid.'/pdf') }}" class="dropdown-item">{{ __('PDF') }}</a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 border-end">
            <div class="vh-100">
                @php
                    $string = $project->category->metadata;
                    $fields = json_decode($string, true);
                @endphp
                @foreach ($fields as $key => $field)
                <div class="mt-5">
                    <label class="small sentence-case">{{ $field['title'] }}</label>
                    @if ($field['type'] == 'input')
                        <form action="{{ url('project/'.$project->uuid.'/edit') }}">
                            @csrf
                            <input class="form-control form-control-sm form-control-shadow rounded project-input" name="fields[{{ $key }}]" value="{{ Helper::getArrayKey($key, json_decode($project->metadata, true)) }}" placeholder="{{ $field['placeholder'] }}">
                        </form>
                    @elseif ($field['type'] == 'textarea')
                        <form action="{{ url('project/'.$project->uuid.'/edit') }}">
                            @csrf
                            <textarea name="fields[{{ $key }}]" class="form-control form-control-sm form-control-shadow rounded project-input" placeholder="{{ $field['placeholder'] }}" cols="30" rows="5">{{ Helper::getArrayKey($key, json_decode($project->metadata, true)) }}</textarea>
                        </form>
                    @endif
                </div>
                @endforeach
                <div class="row">
                    <div class="mt-5 col-md-6">
                        <form action="{{ url('project/'.$project->uuid.'/edit') }}">
                            @csrf
                            <label class="small">{{ __('Choose your tone') }}</label>
                            <select name="fields[tone]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="" selected="" disabled>{{ __('Select tone') }}</option>
                                <option value="Friendly" {{ Helper::getArrayKey('tone', json_decode($project->metadata, true)) == 'Friendly' ? 'selected' : '' }}>{{ __('Friendly') }}</option>
                                <option value="Relaxed" {{ Helper::getArrayKey('tone', json_decode($project->metadata, true)) == 'Relaxed' ? 'selected' : '' }}>{{ __('Relaxed') }}</option>
                                <option value="Professional" {{ Helper::getArrayKey('tone', json_decode($project->metadata, true)) == 'Professional' ? 'selected' : '' }}>{{ __('Professional') }}</option>
                                <option value="Persuasive" {{ Helper::getArrayKey('tone', json_decode($project->metadata, true)) == 'Persuasive' ? 'selected' : '' }}>{{ __('Persuasive') }}</option>
                            </select>
                        </form>
                    </div>
                    <div class="mt-5 col-md-6">
                        <form action="{{ url('project/'.$project->uuid.'/edit') }}">
                            @csrf
                            <label class="small">{{ __('Language') }}</label>
                            <select name="fields[language]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="" selected="" disabled>{{ __('Select language') }}</option>
                                @foreach (Config::get('prompt_languages') as $lang => $language)
                                    <option value="{{ $language['name'] }}" {{ Helper::getArrayKey('language', json_decode($project->metadata, true)) == $language['name'] ? 'selected' : '' }}>{{ $language['name'] }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
                <div class="mt-5">
                    <button class="btn btn-sm btn-dark w-100 generate-content" data-url="{{ url('project/'.$project->uuid.'/generate') }}" disabled>{{ __('Create Content') }}</button>
                </div>
                <div class="loading-content d-flex justify-content-center mt-3 d-none">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">{{ __('Loading...') }}</span>
                    </div>
                </div>
                <div class="generated-content">
                    @include('user.project.content')
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <textarea id="editorContent" name="editor1" data-url="{{ url('project/'.$project->uuid.'/update-content') }}">{{ $project->content }}</textarea>
        </div>
    </div>
</div>
@endsection