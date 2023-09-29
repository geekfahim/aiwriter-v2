@extends('user.layout')
@section('content')
<div class="navbar-sidebar-aside-content ps-0 pe-0" style="background-color: rgb(249 250 251/1);">
    <div class="position-sticky top-0 z-10 bg-white dark:bg-zinc-700 backdrop-blur">
        <div class="flex items-center justify-center w-full p-2 border-bottom-2 border-gray-200 flex-col min-w-0 border-bottom">
            <div class="font-semibold truncate w-full text-center px-12 text-black dark:text-white">{{ __('common.chat_with_ai') }}</div>
            <div class="text-xs text-gray-400 text-center font-xs">{{ __('common.prompt_ai_to_chat_with_you') }}</div>
        </div>
    </div>
    @include('user.chat.chat')
</div>
    @include('user.chat.script')
@endsection()