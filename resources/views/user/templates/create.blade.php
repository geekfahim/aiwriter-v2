<div class="modal fade" id="js-create-template-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize">{{ $template->name }}</h5>
            <button type="button" class="btn-close js-dismiss-create-template"></button>
            </div>
            <form method="POST" action="{{ url('project/create/'.$template->id) }}" class="js-create-content-form">
                @csrf
                <div class="modal-body">
                    <div>
                        <input type="text" class="form-control form-control-sm rounded-btn shadow-none" name="name" placeholder="{{ __('Project name') }}" autocomplete="off">
                    </div>
                    <span class="text-danger">{{ $userSubscription->available_token == 0 ? 'you have not enough token' : '' }}</span>
                    {{-- {{ $plan->id }} --}}
                </div>
                <div class="modal-footer bg-grey-light">
                    <button type="button" class="btn btn-sm btn-secondary rounded-btn js-dismiss-create-template">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-sm btn-dark rounded-btn">{{ __('Save changes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>