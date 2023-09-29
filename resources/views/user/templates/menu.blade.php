<div class="bg-grey-light ps-2 pe-2 pt-2 pb-2 rounded h-100">
    <h6 class="mt-2 mb-3">Filter By Category</h6>
    <button class="btn js-template-category fw-normal btn-sm {{ Request::segment(2) == NULL ? 'btn-dark btn-pointer' : 'btn-outline-none' }} ps-3 pt-2 pb-2 w-100 text-start mb-2 rounded-btn" data-url="{{ url('templates') }}" data-search="{{ url('templates-search') }}">{{ __('All Templates') }}</button>
    @foreach ($categories as $category)
    <button class="btn fw-normal js-template-category btn-sm {{ Request::segment(2) == $category->id ? 'btn-dark' : 'btn-outline-none' }} ps-3 pt-2 pb-2 w-100 text-start mb-2 rounded-btn text-capitalize" data-url="{{ url('templates/'.$category->id) }}" data-search="{{ url('templates-search/'.$category->id) }}" data-category-id="{{ $category->id }}">{{ $category->category_name }}</button>
    @endforeach
</div>


