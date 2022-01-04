$(".send_message").on("click", function (e){
        e.preventDefault();

        var sam_id = $("input[name=hidden_sam_id]").val();

        var message = $('.message_enter').val();

        var user_id = $('input[name=hidden_user_id]').val();

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

                        if ($(".no_message")[0] != undefined) {
                            $(".no_message").remove();
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
                                            resp.chat.created_at +
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