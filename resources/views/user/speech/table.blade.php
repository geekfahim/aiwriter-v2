@foreach ($projects as $project)
<div role="button" class="border-bottom p-2 project-row">
    <div class="row">
        <div class="col-8 view-template d-flex align-items-center" data-url="{{ url('project/'.$project->uuid) }}">
            <span class="me-2">
                @if ($project->type == 'content')
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M20 12V5.749a.6.6 0 0 0-.176-.425l-3.148-3.148A.6.6 0 0 0 16.252 2H4.6a.6.6 0 0 0-.6.6v18.8a.6.6 0 0 0 .6.6H11M8 10h8M8 6h4m-4 8h3m6.954 2.94l1-1a1.121 1.121 0 0 1 1.586 0v0a1.121 1.121 0 0 1 0 1.585l-1 1m-1.586-1.586l-2.991 2.991a1 1 0 0 0-.28.553l-.244 1.557l1.557-.243a1 1 0 0 0 .553-.28l2.99-2.992m-1.585-1.586l1.586 1.586"></path><path d="M16 2v3.4a.6.6 0 0 0 .6.6H20"></path></g></svg> 
                @elseif($project->type == 'image')
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="m14 2l6 6v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8m4 18V9h-5V4H6v16h12m-1-7v6H7l5-5l2 2m-4-5.5A1.5 1.5 0 0 1 8.5 12A1.5 1.5 0 0 1 7 10.5A1.5 1.5 0 0 1 8.5 9a1.5 1.5 0 0 1 1.5 1.5Z"></path></svg>  
                @elseif($project->type == 'audio')
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M12 3a1 1 0 0 1 .993.883L13 4v16a1 1 0 0 1-1.993.117L11 20V4a1 1 0 0 1 1-1ZM8 6a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1Zm8 0a1 1 0 0 1 1 1v10a1 1 0 1 1-2 0V7a1 1 0 0 1 1-1ZM4 9a1 1 0 0 1 1 1v4a1 1 0 1 1-2 0v-4a1 1 0 0 1 1-1Zm16 0a1 1 0 0 1 .993.883L21 10v4a1 1 0 0 1-1.993.117L19 14v-4a1 1 0 0 1 1-1Z"/></g></svg>
                @endif
            </span>
            <small class="font-xs">{{ $project->name }}</small>
            @if ($project->type == 'image')
            @php
                $images = DB::table('image_contents')->where('document_id', $project->id)->where('deleted_at', null)->limit(5)->orderBy('id', 'desc')->get();
            @endphp
            <div class="grid_groups_wrapper ms-2">
                <div class="group">
                    <a class="route d-flex">
                        @foreach ($images as $image)
                        <div class="rounded-circle default-avatar member-overlap-item" style="background: url({{ asset('uploads/images/' . $image->url) }}) 0 0 no-repeat; background-size: cover;">
                        </div>
                        @endforeach
                    </a>
                </div>
            </div>
            @endif
        </div>
        <div class="col-4">
            <div class="float-end">
                <div class="d-flex align-items-center">
                    <small class="text-muted font-xs">{{ Helper::time_ago($project->updated_at) }}</small>
                    <div class="ms-3">
                        <span role="button" id="dropdownMenuReference" data-bs-toggle="dropdown" aria-expanded="false" data-reference="parent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M16 12a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2m-6 0a2 2 0 0 1 2-2a2 2 0 0 1 2 2a2 2 0 0 1-2 2a2 2 0 0 1-2-2Z"/></svg>
                        </span>
                        <div class="dropdown-menu dropdown-menu-sm" aria-labelledby="dropdownMenuReference">
                            <a class="dropdown-item view-template font-sm" href="{{ url('project/'.$project->uuid) }}">{{ __('View/Edit') }}</a>
                            @if ((Helper::is_trial_mode() || Helper::subscription()->plan->allow_export == 1))
                            <a href="{{ url('project/export/'.$project->uuid.'/word') }}" class="dropdown-item font-sm">{{ __('Download as Word') }}</a>
                            <a href="{{ url('project/export/'.$project->uuid.'/pdf') }}" class="dropdown-item font-sm">{{ __('Download as PDF') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <button class="dropdown-item delete-project font-sm" data-url="{{ url('project/delete/'.$project->uuid) }}">{{ __('Delete') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="d-flex fs-7 float-end mt-4">
    <nav>
        {{  $projects->links('pagination::bootstrap-4')  }}
    </nav>
</div>