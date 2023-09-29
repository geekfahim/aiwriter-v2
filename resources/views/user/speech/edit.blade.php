@extends('user.layout')
@section('content')
<div class="navbar-sidebar-aside-content content-space-1 content-space-md-2 px-lg-5 px-xl-10">
    <h5 class="text-capitalize d-flex align-items-center">
        <div class="icon-bg bg-grey-light d-flex justify-content-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"></path><path fill="currentColor" d="M12 3a1 1 0 0 1 .993.883L13 4v16a1 1 0 0 1-1.993.117L11 20V4a1 1 0 0 1 1-1ZM8 6a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1Zm8 0a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1ZM4 9a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm16 0a1 1 0 0 1 .993.883L21 10v4a1 1 0 0 1-1.993.117L19 14v-4a1 1 0 0 1 1-1Z"></path></g></svg>
        </div>
        <div class="ms-2">
            {{ __('Speech To Text Generator') }}
        </div>
    </h5>
    <form method="POST" action="{{ url('audio/' . $project->uuid) }}" class="js-audio-form">
        @csrf
        <div class="border-bottom pb-4">
            <div class="row align-items-center">
                <div class="col-4">
                    <input type="text" name="name" class="form-control form-control-sm form-control-shadow project-input" placeholder="Image Name" value="{{ $project->name }}" autocomplete="off">
                </div>
                <div class="col-8">
                    <div class="float-end">
                        @if (isset($audio))
                        <div>
                            <audio controls>
                                <source src="{{ asset('uploads/audio/'. $audio->file) }}" type="audio/mpeg">
                                {{ __('Your browser does not support the audio element.') }}
                            </audio>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 border-end">
                <div class="mb-5">
                    <div class="mt-5">
                        <label class="small sentence-case mb-2">{{ __('Upload Audio') }}</label>
                        <input type="file" class="form-control form-control-sm shadow-none bg-grey-light w-50 rounded-btn" name="audio_file">
                        <small class="font-xs">
                            <i class="fa fa-info-circle"></i>
                            {{ __('Required format: mp3, mp4, mpeg, mpga, m4a, wav, or webm') }}
                        </small>
                    </div>
                    <div class="mt-5 row">
                        <div class="col-md-6">
                            <label class="small">{{ __('Mode') }}</label>
                            <select name="fields[mode]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="transcribe" {{ Helper::getArrayKey('mode', json_decode($project->metadata, true)) == 'transcribe' ? 'selected' : '' }}>{{ __('Transcribe') }}</option>
                                <option value="translate" {{ Helper::getArrayKey('mode', json_decode($project->metadata, true)) == 'translate' ? 'selected' : '' }}>{{ __('Translate') }}</option>
                            </select>
                        </div>
                        <!--<div class="col-md-6">
                            <label class="small">{{ __('Language') }}</label>
                            <select name="fields[medium]" class="form-select form-select-sm form-control-shadow rounded project-input">
                                <option value="" selected="">{{ __('None') }}</option>
                                
                            </select>
                        </div>-->
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-sm btn-dark w-100 js-generate-audio-text" data-url="">{{ __('common.generate_text') }}</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 js-speech-view">
                @include('user.speech.view')
            </div>
        </div>
    </form>
</div>
@endsection