<div class="inner-width mt-7 p-4 d-none" style="max-width: 35rem;">
        <div class="col-6">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <span class="me-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="-2 -2.5 24 24"><path fill="currentColor" d="M3.656 17.979A1 1 0 0 1 2 17.243V15a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H8.003l-4.347 2.979zm.844-3.093a.536.536 0 0 0 .26-.069l2.355-1.638A1 1 0 0 1 7.686 13H12a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v5c0 .54.429.982 1 1c.41.016.707.083.844.226c.128.134.135.36.156.79c.003.063.003.177 0 .37a.5.5 0 0 0 .5.5zm11.5-4.87a7.136 7.136 0 0 0 0 .37v-.37c.02-.43.028-.656.156-.79c.137-.143.434-.21.844-.226c.571-.018 1-.46 1-1V3a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1H5V2a2 2 0 0 1 2-2h11a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2v2.243a1 1 0 0 1-1.656.736L16 13.743v-3.726z"/></svg></span>
                <h6 class="mb-0">{{ __('common.example_prompts') }}</h6>
            </div>
            <div class="card bg-grey-light mb-3 shadow-sm">
                <div class="card-body p-2">
                    <small>{{ __('common.write_a_100_word_blog_on_best_holiday_destinations') }}</small>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z"/></svg>
                </div>
            </div>
            <div class="card bg-grey-light mb-3 shadow-sm">
                <div class="card-body p-2">
                    <small>{{ __('common.give_me_creative_ideas_on_my_wedding_blog') }}</small>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M16.01 11H4v2h12.01v3L20 12l-3.99-4z"/></svg>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="d-flex justify-content-center align-items-center mb-2">
                <span class="me-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 9.47V11h3.76L13 14.53V13H9.24L11 9.47M13 1L6 15h5v8l7-14h-5V1Z"/></svg></span>
                <h6 class="mb-0">{{ __('common.how_it_works') }}</h6>
            </div>
            <div class="card bg-grey-light mb-3 shadow-sm">
                <div class="card-body p-2">
                    <small>{{ __('common.how_it_works_step_1') }}</small>
                </div>
            </div>
            <div class="card bg-grey-light mb-3 shadow-sm">
                <div class="card-body p-2">
                    <small>{{ __('common.how_it_works_step_2') }}</small>
                </div>
            </div>
        </div>
    </div>
    <div class="chat-messages border-top">
        <div class="main-personality">
            <div class="inner-width align-items-center justify-content-center" style="max-width: 35rem;">
                <div class="text-sm border-gray-200 border px-4 py-1 rounded" style="background-color: rgb(240, 255, 240);font-size: 0.895em;">{{ __('common.you_are_chatting_with') }} <b>{{ session('personality') ? session('personality') : 'General AI'  }}</b> </div>
            </div>
        </div>
        @foreach ($chats as $chat)
        <div class="user-message">
            <div class="inner-width bg-white p-2">
                <div class="chat-user-initials bg-secondary text-white d-flex align-items-center justify-content-center">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 12q-1.65 0-2.825-1.175T8 8q0-1.65 1.175-2.825T12 4q1.65 0 2.825 1.175T16 8q0 1.65-1.175 2.825T12 12Zm-8 8v-2.8q0-.85.438-1.563T5.6 14.55q1.55-.775 3.15-1.163T12 13q1.65 0 3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2V20H4Z"/></svg></span>
                </div>
                <div>
                    {{ $chat->prompt }}
                </div>
            </div>
        </div>
        <div class="bot-message">
            <div class="inner-width bg-grey-light p-2 rounded">
                <div class="chat-user-initials d-flex bg-white align-items-center justify-content-center">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M13 8.58c.78 0 1.44.61 1.44 1.42s-.66 1.44-1.44 1.44s-1.42-.66-1.42-1.44s.61-1.42 1.42-1.42M13 3c3.88 0 7 3.14 7 7c0 2.8-1.63 5.19-4 6.31V21H9v-3H8c-1.11 0-2-.89-2-2v-3H4.5c-.42 0-.66-.5-.42-.81L6 9.66A7.003 7.003 0 0 1 13 3m3 7c0-.16 0-.25-.06-.39l.89-.66c.05-.04.09-.18.05-.28l-.8-1.36c-.05-.09-.19-.14-.28-.09l-.99.42c-.18-.19-.42-.33-.65-.42L14 6.19c-.03-.14-.08-.19-.22-.19h-1.59c-.1 0-.19.05-.19.19l-.14 1.03c-.23.09-.47.23-.66.42l-1.03-.42c-.09-.05-.17 0-.23.09l-.8 1.36c-.05.14-.05.24.05.28l.84.66c0 .14-.03.28-.03.39c0 .13.03.27.03.41l-.84.65c-.1.05-.1.14-.05.24l.8 1.4c.06.1.14.1.23.1l.99-.43c.23.19.42.29.7.38l.14 1.08c0 .09.09.17.19.17h1.59c.14 0 .19-.08.22-.17l.16-1.08c.23-.09.47-.19.65-.37l.99.42c.09 0 .23 0 .28-.1l.8-1.4c.04-.1 0-.19-.05-.24l-.83-.65V10Z"/></svg></span>
                </div>
                <div>
                    {!! nl2br(e($chat->content)) !!}
                </div>
            </div>
        </div>  
        @endforeach  
    </div>
    <div class="chat-footer p-3 pb-7">
        <div class="inner-width pt-3 pb-1 mt-0 text-center">
            <div class="input-group">
                <span class="input-group-text p-0 border-0 me-2 font-xs">{{ __('common.current_personality') }}</span>
                <select name="personality" class="form-control form-control-sm shadow-none ps-3 p-0 rounded bg-grey-light" id="selectPersonality" onchange="postToUrlAndRefresh()" style="max-width: 15em;min-height: calc(1em + 1.125rem);">
                    <option value="General AI" {{ session('personality') == 'General' ? 'selected' : '' }}>General AI</option>
                    <option value="Personal Trainer" {{ session('personality') == 'Personal Trainer' ? 'selected' : '' }}>Personal Trainer</option>
                    <option value="English Translator" {{ session('personality') == 'English Translator' ? 'selected' : '' }}>English Translator</option>
                    <option value="Motivational Coach" {{ session('personality') == 'Motivational Coach' ? 'selected' : '' }}>Motivational Coach</option>
                    <option value="Interviewer" {{ session('personality') == 'Interviewer' ? 'selected' : '' }}>Interviewer</option>
                    <option value="Relationship Coach" {{ session('personality') == 'Relationship Coach' ? 'selected' : '' }}>Relationship Coach</option>
                    <option value="Travel Guide" {{ session('personality') == 'Travel Guide' ? 'selected' : '' }}>Travel Guide</option>
                    <option value="Life Coach" {{ session('personality') == 'Life Coach' ? 'selected' : '' }}>Life Coach</option>
                    <option value="Accountant" {{ session('personality') == 'Accountant' ? 'selected' : '' }}>Accountant</option>
                    <option value="Philosopher" {{ session('personality') == 'Philosopher' ? 'selected' : '' }}>Philosopher</option>
                    <option value="Standup Comedian" {{ session('personality') == 'Standup Comedian' ? 'selected' : '' }}>Standup Comedian</option>
                </select>
            </div>
        </div>
        <form class="inner-width pb-0 mb-0 pt-0" action="{{ url('chat') }}">
            @csrf
            <div class="input-group shadow-sm">
                <input type="text" class="form-control chat-input bg-grey-light" placeholder="Type your message...">
                <button class="input-group-text send-button bg-grey-light">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M3 18.5v-13q0-.55.45-.838t.95-.087l15.4 6.5q.625.275.625.925t-.625.925l-15.4 6.5q-.5.2-.95-.088T3 18.5ZM5 17l11.85-5L5 7v3.5l6 1.5l-6 1.5V17Zm0-5V7v10v-5Z"/></svg>
                </button>
            </div>
        </form>
    </div>