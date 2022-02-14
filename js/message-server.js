(function() {
    const msg_server = "server.php";
    var interval;
    var msg_number = 0;
    var elementSubject;
    var elementMessageText;
    var elementSelectUser;

    function createToast(sender, subject, message, time) {
        var wrapper = document.createElement('div');
                    wrapper.innerHTML = 
                        `<div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto" id="toastSender-${msg_number}"><mark>${sender}</mark>: ${subject}</strong>
                                <small class="text-muted" id="toastTime-${msg_number}">${time}</small>
                                <button id="btnClose-${msg_number}" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body" id="toastMessage-${msg_number}">${message}
                                <div class="mt-2 pt-2 border-top">
                                    <button type="button" class="btn btn-primary btn-sm" id="btnReply-${msg_number}">Reply</button>
                                </div>
                            </div>
                        </div>`;
        return wrapper;
    }

    function loadNewMessages() {
        $.ajax({
            type: "POST",
            url: msg_server,
            data: {query:"load"},
            success: function(retr){
                var msgs = retr.data;
                const toastContainer = document.getElementById("toastPlacement");
                for(msg in msgs) {
                    msg_number++;
                    toastContainer.append(createToast(msgs[msg]["sender"], msgs[msg]["subject"], msgs[msg]["message"], msgs[msg]["time"]));

                    $(`#btnReply-${msg_number}`).click(function (event) {
                        var currentId = event.currentTarget.getAttribute("Id").split("-")[1];
                        var caption = document.getElementById(`toastSender-${currentId}`).innerText.split(":", 2);
                        var sender = caption[0];
                        var subject = caption[1];
                        var time = document.getElementById(`toastTime-${currentId}`).innerText;
                        var message = document.getElementById(`toastMessage-${currentId}`).innerText.slice(0,-6); // Remove 'Reply'

                        var replyText =`"${sender}: ${subject} [${time}]\n${message}"\n\n`;

                        const options = Array.from(elementSelectUser.options);
                        const optionToSelect = options.find(item => item.text === sender);
                        optionToSelect.selected = true;
                        elementSubject.value = `Fwd: ${subject}`;
                        elementMessageText.value = `${replyText}`;
                        elementMessageText.focus();

                        document.getElementById(`btnClose-${currentId}`).click();
                    });
                }
            },
            dataType: "json"
        }).fail(function () {
            console.log("error");
        });
    }
    
    $(document).ready(function () {

        elementSubject = document.getElementById("subject");
        elementMessageText = document.getElementById("messageText");
        elementSelectUser = document.getElementById("select-user");

        $('#senderForm').submit(function (event) {
            event.preventDefault();
            // window.history.back;
            msg = $(this).serializeArray();
            console.log(msg);
            

            $.ajax({
                type: "POST",
                url: msg_server,
                data: {query:"send", data: msg},
                success: function(retr){
                    console.log(retr);
                    elementSubject.value = "";
                    elementMessageText.value = "";
                    elementSelectUser.value = "";
                    if (retr["status"] == "ok") {
                        showAlert("success", "Message have been sent successfully!");
                    } else {
                        showAlert("danger", "An error occurred while sending the message");
                    }
                },
                dataType: "json"
            }).fail(function (err) {
                console.log(JSON.stringify(err));
            });

            function showAlert(alertType, alertMessage) {
                const alertPlaceholder = document.getElementById('liveAlertPlaceholder');
                var wrapper = document.createElement('div');
                wrapper.innerHTML = '<div id="alert" class="alert alert-' + alertType + ' alert-dismissible" role="alert">' + alertMessage + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                alertPlaceholder.append(wrapper);
                window.setTimeout(function() {
                    $('#alert').alert('close');
                }, 5000);
            }

        });
        loadNewMessages();
        interval = setInterval(loadNewMessages, 5000);
 
    });
    

})();
