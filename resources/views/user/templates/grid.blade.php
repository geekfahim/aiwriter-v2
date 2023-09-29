<div class="row" id="gridItemsContainer">
    @if(count($templates)>0)
        @foreach ($templates as $template)
        <div class="col-md-3 mb-3">
            <!-- Card -->
            <div class="card card-xs shadow-sm text-start h-100 bg-cover-image bg-cover-image-5" role="button">
                <div class="card-body js-select-template p-4" data-url="{{ url('project/create/' . $template->id) }}">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-0 text-capitalize">{{ $template->name }}</h6> &nbsp;&nbsp;
                        <small class="font-xs ml-5">{{ $template->category_new->category_name ?? 'Free style' }}</small>
                    </div>
                    <small class="text-muted font-xs">{{ $template->description }}</small>
                    
                </div>
                <!--<div class="text-end mb-3">-->
                <!--    <a href="#" type="button" class="btn-dark btn-pointerr js-select-template px-3" data-url="{{ url('project/create/' . $template->id) }}">-->
                <!--        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width=20>-->
                <!--            <path d="M64 464H288c8.8 0 16-7.2 16-16V384h48v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V224c0-35.3 28.7-64 64-64h64v48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM224 352c-35.3 0-64-28.7-64-64V64c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V288c0 35.3-28.7 64-64 64H224z" />-->
                <!--        </svg>-->
                <!--    </a>-->
                <!--</div>-->
                
                @if($template->monthly_price != 0 && $template->yearly_price != 0)    
                    <div class="text-end mb-3">
                        @if(!$template->template_id)
                            <span class="px-3">
                                <span class="js-select-template" data-url="{{ url('project/create/' . $template->id) }}" >Discover</span>
                            <a href="#" type="button" class="btn-dark btn-pointerr px-3" >
                                <span class=" tooltip" data-toggle="tooltip" data-placement="top" title="Add To collection"  onclick="addToCollection({{$template->id}})" style="opacity:1;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width=20><path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zM200 344V280H136c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H248v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z"/></svg>
                                </span>
                            </a>
                            </span>
                        @endif
                    </div>
                @else
                    
                    <div class="text-end mb-3">
                        <a href="#" type="button" class="btn-dark btn-pointerr px-3">
                            <span class="badge badge-primary tooltip" data-toggle="tooltip" data-placement="top" title="Copy to Clipboard"  onclick="copyPrompt(this)" style="opacity:1;">
                                <input class="d-none" value="{{ $template->description }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width=20>
                                    <path d="M64 464H288c8.8 0 16-7.2 16-16V384h48v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V224c0-35.3 28.7-64 64-64h64v48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM224 352c-35.3 0-64-28.7-64-64V64c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V288c0 35.3-28.7 64-64 64H224z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                @endif
            </div>
            <!-- End Card -->
        </div>
        @endforeach
    @else
        <div class="col-md-3 mb-3">
            <div class="card card-xs shadow-sm text-start h-100" role="button">
                <div class="card-body p-4">
                    <h6 class="mb-3 text-capitalize" onclick="upgrade">Upgrade Plan to access Prompt</h6>
                    <button type="button" class="btn btn-dark btn-pointer w-100 pt-2 pb-2" onclick="showModal()">Select Plan</button>
                </div>
            </div>
        </div>
    @endif

</div>
<script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
</script>