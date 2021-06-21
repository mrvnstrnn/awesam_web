<div class="scrollbar-container ps ps--active-y" style="height: 400px; overflow-y: scroll !important;">
    <div class="chat_div p-2">
        <div class="chat-wrapper p-1">
            @php
                $chats = \App\Models\Chat::select('users.name', 'chat.user_id', 'profiles.profile', 'chat.comment', 'chat.timesptamp')
                                            ->join('users', 'users.id', 'chat.user_id')
                                            ->join('profiles', 'profiles.id', 'users.profile_id')
                                            ->where('chat.sam_id', $site[0]->sam_id)
                                            ->orderBy("chat.timesptamp", "asc")
                                            ->get();
            @endphp


            <div class="chat-content chat_content{{ $site[0]->sam_id }}">
                @forelse ($chats as $chat)
                    @if ($chat->user_id == \Auth::id())
                        <div class="chat_user_id{{ $chat->user_id }}">
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
                        <div class="chat_user_id{{ $chat->user_id }}">
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
<input type="hidden" name="hidden_user_id" value="{{ \Auth::id() }}">

<div class="d-flex">
    <input placeholder="Write here and hit enter to send..." type="text" class="form-control-sm form-control message_enter mr-2">
    <button class="btn btn-primary pl-5 pr-5 send_message">Send</button>
</div>

<script src="{{ asset("js/chat.js") }}"></script>

<script>
    $(".scrollbar-container.ps.ps--active-y").scrollTop($(".chat-wrapper").height() * $(".chat-wrapper").height());
</script>

{{-- <script>
    $(".send_message").on("click", function (e){
        e.preventDefault();

        var sam_id = $("input[name=hidden_sam_id]").val();

        var message = $('.message_enter').val();

        var user_id = "{{ \Auth::id() }}";

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
                        var class_name = "";
                        if (resp.chat.user_id == user_id){
                            class_name = "chat-box-wrapper-right float-right";
                        } else {
                            class_name = "";
                        }

                        $(".chat-content.chat_content"+resp.chat.sam_id).append(
                            '<div class="chat_user_id{{ $chat->user_id }}">' +
                                '<div class="chat-box-wrapper '+class_name+' ">' +
                                    '<div>' +
                                        '<div class="chat-box">' +
                                            resp.chat.comment +
                                        '</div>' +
                                        '<small class="opacity-6">' +
                                            resp.chat.profile + " : " + resp.chat.name + '<br>' +
                                            '<i class="fa fa-calendar-alt mr-1"></i>' +
                                            resp.chat.timesptamp +
                                        '</small>' +
                                    '</div>' +
                                    '<div>' +
                                        '<div class="avatar-icon-wrapper ml-1">' +
                                            '<div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>' +
                                            '<div class="avatar-icon avatar-icon-lg rounded">' +
                                                '<img src="/images/avatars/2.jpg" alt="">' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>'
                        );

                        $(".scrollbar-container.ps.ps--active-y").scrollTop($(".chat-wrapper").height() * $(".chat-wrapper").height());

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

</script> --}}