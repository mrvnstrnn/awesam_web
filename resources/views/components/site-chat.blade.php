<div class="scrollbar-container ps ps--active-y" style="height: 400px; overflow-y: scroll !important;">
    <div class="p-2">
        <div class="chat-wrapper p-1">
            @php
                $chats = \App\Models\Chat::select('users.name', 'chat.user_id', 'profiles.profile', 'chat.comment', 'chat.timesptamp')
                                            ->join('users', 'users.id', 'chat.user_id')
                                            ->join('profiles', 'profiles.id', 'users.profile_id')
                                            ->where('chat.sam_id', $site[0]->sam_id)
                                            ->orderBy("chat.timesptamp", "asc")
                                            ->get();
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
                                        {{ $chat->profile }} : {{ $chat->name }}<br>
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
                    <div class="text-center pt-5"> 
                        <i class="fa fa-envelope fa-4x"></i>
                        <h3 class="text-center">no message</h3>    
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="hidden_sam_id" value="{{ $site[0]->sam_id }}">
{{-- <input placeholder="Write here and hit enter to send..." type="text" class="form-control-sm form-control message_enter"> --}}
<div class="d-flex">
    <input placeholder="Write here and hit enter to send..." type="text" class="form-control-sm form-control message_enter mr-2">
    <button class="btn btn-primary pl-5 pr-5 send_message">Send</button>
</div>
{{-- <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 400px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 265px;"></div></div></div> --}}

<script>
    //chat
    $(".send_message").on("click", function (e){
        e.preventDefault();

        var sam_id = $("input[name=hidden_sam_id]").val();

        var message = $('.message_enter').val();

        if (message != ""){

            $.ajax({
                url: "/chat-send",
                method: "POST",
                data: {
                    comment : message,
                    sam_id : sam_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (resp){
                    if (!resp.error){
                        $(".message_enter").val("");
                        // $(".chat-content").load(window.location.href + " .chat-content" );
                    } else {
                        toastr.error(resp.message, "Error");
                    }
                },
                error: function (resp) {
                    toastr.error(resp.message, "Error");
                }
            });
        }

    });

    $('.message_enter').keypress(function (e) {

        var key = e.which;
        if(key == 13) {
            var message = $('.message_enter').val();

            if (message != ""){
                $(".send_message").trigger("click");
            }
        }
    });  


    // end chat

</script>