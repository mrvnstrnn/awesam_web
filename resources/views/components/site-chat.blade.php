<div class="scrollbar-container ps ps--active-y" style="height: 400px; overflow-y: scroll !important;">
    <div class="p-2">
        <div class="chat-wrapper p-1">
            @php
                $chats = \App\Models\Chat::where('sam_id', $site[0]->sam_id)->orderBy("timesptamp", "asc")->get();
            @endphp

            <div class="chat-content">
                @forelse ($chats as $chat)
                    @if ($chat->user_id == \Auth::id())
                        <div class="">
                            <div class="chat-box-wrapper chat-box-wrapper-right float-right">
                                <div>
                                    <div class="chat-box">
                                        {{ $chat->comment }}
                                    </div>
                                    <small class="opacity-6">
                                        <i class="fa fa-calendar-alt mr-1"></i>
                                        {{ $chat->timesptamp }}
                                    </small>
                                </div>
                                <div>
                                    <div class="avatar-icon-wrapper ml-1">
                                        <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                        <div class="avatar-icon avatar-icon-lg rounded">
                                            <img src="/images/avatars/2.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="chat-box-wrapper">
                            <div>
                                <div class="avatar-icon-wrapper mr-1">
                                    <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                                    <div class="avatar-icon avatar-icon-lg rounded">
                                        <img src="/images/avatars/2.jpg" alt="">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="chat-box">
                                    {{ $chat->comment }}
                                </div>
                                <small class="opacity-6">
                                    <i class="fa fa-calendar-alt mr-1"></i>
                                    {{ $chat->timesptamp }}
                                </small>
                            </div>
                        </div>
                    @endif

                @empty
                    <h1 class="text-center">No message here</h1>
                @endforelse
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
<input placeholder="Write here and hit enter to send..." type="text" class="form-control-sm form-control message_enter">
{{-- <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 400px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 265px;"></div></div></div> --}}
