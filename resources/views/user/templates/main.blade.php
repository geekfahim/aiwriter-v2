<div class="modal fade" id="templateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-grey-light pb-3">
                <h4 class="modal-title" id="exampleModalLabel">{{ __('Select Template') }}</h4>
                <button type="button" class="btn-close rounded-btn bg-white p-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="">
                        <div class="">
                            <div class="row align-items-center">
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-3 d-none d-md-block">
                                    @include('user.templates.menu')
                                </div>
                                <div class="col-md-9 col-12">
                                    <div class="mb-3 p-4 pt-0 pb-1">
                                        <div class="input-group">
                                            <span class="input-group-text rounded-btn border-0 bg-grey-light ps-4 pe-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M11 2c4.968 0 9 4.032 9 9s-4.032 9-9 9s-9-4.032-9-9s4.032-9 9-9zm0 16c3.867 0 7-3.133 7-7c0-3.868-3.133-7-7-7c-3.868 0-7 3.132-7 7c0 3.867 3.132 7 7 7zm8.485.071l2.829 2.828l-1.415 1.415l-2.828-2.829l1.414-1.414z"></path>
                                                </svg>
                                            </span>
                                            <input type="text" class="form-control form-control-sm rounded-btn shadow-none bg-grey-light border-0 template-search" placeholder="{{ __('Search Template') }}" data-url="{{ url('templates-search/'.Request::segment(2)) }}">
                                        </div>
                                    </div>
                                    <div class="grid-items p-4">
                                        @include('user.templates.grid')
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
