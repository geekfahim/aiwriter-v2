<div class="row generated-images border-bottom">
    @foreach ($images as $image)
        <div class="col-md-3 mt-2 mb-3">
            <div class="img-wrap rounded shadow-md" role="button">
                <button type="button" class="btn p-0 delete">
                    <img class="js-delete-image" data-url="{{ url('image/' . $image->id) }}" src="{{ url('images/icons/trash.svg') }}" alt="">
                </button>
                <a href="{{ url('image-download/' . $image->id) }}" role="button" class="btn p-0 download">
                    <img src="{{ url('images/icons/download-rounded.svg') }}" alt="">
                </a>
                <button type="button" class="enlarge btn btn-dark font-xs p-1 ps-2 pe-2 js-show-image" data-url="{{ url('image/' . $image->project->uuid . '/' . $image->id) }}">
                    {{ __('view') }}
                </button>
                <img src="{{ asset('uploads/images/' . $image->url) }}" class="image-minified rounded mw-100" alt="">
            </div>
        </div>
    @endforeach
</div>
<div class="imageView d-flex position-relative h-100 justify-content-center mt-3">
    <div class="imageContainer js-image-container {{ $imageCount == 0 ? 'd-none' : '' }}">
        <div class="img-wrap" role="button">
            <button type="button" class="btn p-0 delete">
                <img class="js-delete-image" data-url="{{ isset($mainImage) ? url('image/' . $mainImage->id) : '' }}" src="{{ url('images/icons/trash.svg') }}" alt="">
            </button>
            <a href="{{ isset($mainImage) ? url('image-download/' . $mainImage->id) : '' }}" class="download" role="button">
                <img src="{{ isset($mainImage) ? url('images/icons/download-rounded.svg') : '' }}" alt="">
            </a>
            <img src="{{ $imageCount > 0 ? asset('uploads/images/' . $mainImage->url) : '' }}" class="image-minified js-generated-image shadow-sm rounded mw-100" alt="">
        </div>
    </div>
    <div class="loading-content d-flex align-items-center justify-content-center d-none">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">{{ __('Loading...') }}</span>
        </div>
        <div class="ms-2">{{ __('Generating Image') }}</div>
    </div>
</div>