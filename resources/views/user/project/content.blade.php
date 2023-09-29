@if ($generate == false)
<div class="mt-5 border-top pt-4 content-container">
    <div class="card shadow-sm">
        <div class="card-body">
            <small>{{ __('Your Plan has been depleted. Top up to create more content.') }}</small>
            <a href="{{ url('/billing') }}" class="btn btn-sm btn-dark mt-3">{{ __('Purchase Plan') }}</a>
        </div>
    </div>
</div>
@endif
@foreach ($contents as $content)
<div class="mt-5 border-top pt-4 content-container">
    <div class="rounded bg-grey-light p-3">
        <small class="content-description">{!! nl2br(e($content->content)) !!}</small>
    </div>
    <div class="d-flex mt-2">
        @if (Helper::is_trial_mode() || Helper::subscription()->plan->allow_copy == 1)
            <button class="btn btn-sm copy-action rounded btn-outline-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M5 22q-.825 0-1.413-.587Q3 20.825 3 20V6h2v14h11v2Zm4-4q-.825 0-1.412-.587Q7 16.825 7 16V4q0-.825.588-1.413Q8.175 2 9 2h9q.825 0 1.413.587Q20 3.175 20 4v12q0 .825-.587 1.413Q18.825 18 18 18Zm0-2h9V4H9v12Zm0 0V4v12Z"/></svg>
                {{ __('Copy') }}
            </button>
        @endif
        <button class="btn btn-sm content-btn-action rounded btn-outline-secondary ms-2" data-action="save" data-url="{{ url('project/content/'.$content->id.'/save') }}">
            @if ($content->is_saved == 1)
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="#0ABF53" d="m12 21.35l-1.45-1.32C5.4 15.36 2 12.27 2 8.5C2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08C13.09 3.81 14.76 3 16.5 3C19.58 3 22 5.41 22 8.5c0 3.77-3.4 6.86-8.55 11.53L12 21.35Z"/></svg>
            @else
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m12.1 18.55l-.1.1l-.11-.1C7.14 14.24 4 11.39 4 8.5C4 6.5 5.5 5 7.5 5c1.54 0 3.04 1 3.57 2.36h1.86C13.46 6 14.96 5 16.5 5c2 0 3.5 1.5 3.5 3.5c0 2.89-3.14 5.74-7.9 10.05M16.5 3c-1.74 0-3.41.81-4.5 2.08C10.91 3.81 9.24 3 7.5 3C4.42 3 2 5.41 2 8.5c0 3.77 3.4 6.86 8.55 11.53L12 21.35l1.45-1.32C18.6 15.36 22 12.27 22 8.5C22 5.41 19.58 3 16.5 3Z"/></svg>   
            @endif
            {{ $content->is_saved == 1 ? __('Saved') : __('Save') }}
        </button>
        <button class="btn btn-sm content-btn-action rounded btn-outline-secondary ms-2" data-action="delete" data-url="{{ url('project/content/'.$content->id.'/delete') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2zm4 11H8c-.55 0-1-.45-1-1s.45-1 1-1h8c.55 0 1 .45 1 1s-.45 1-1 1z"/></svg>
            {{ __('Remove') }}
        </button>
    </div>
</div>
@endforeach
<!--<div class="mt-5 border-top pt-1">
    <div class="d-flex justify-content-center">
        <button class="btn btn-sm btn-secondary">Copy all results</button>
    </div>
</div>-->