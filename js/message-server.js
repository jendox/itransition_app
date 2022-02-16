(function() {
    const msg_server = "server.php";
    var msg_number = 0;
    var userList = null;

    function createToast(msg) {
        var wrapper = document.createElement('div');
        wrapper.innerHTML = 
            `<div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto" id="toastSender-${msg_number}"><mark>${msg["sender"]}</mark>: ${msg["subject"]}</strong>
                    <small class="text-muted" id="toastTime-${msg_number}">${msg["time"]}</small>
                    <button id="btnClose-${msg_number}" type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="toastMessage-${msg_number}">${msg["message"]}
                    <div class="mt-2 pt-2 border-top">
                        <button type="button" class="btn btn-primary btn-sm" id="btnReply-${msg_number}">Reply</button>
                    </div>
                </div>
            </div>`;
        return wrapper;
    }

    function getUserList() {
        $.ajax({
            type: "POST",
            url: msg_server,
            data: {query:"users"},
            success: function(retr) {
                userList = retr.data;
                let users = retr.data;
                for(let user of users) {
                    $('#list-group-users').append(
                        `<label class="list-group-item" value="${user.username}">
                        <input class="form-check-input me-1" type="checkbox" value="${user.id}">${user.username}
                        </label>`
                    )
                }
            }
        }).fail(function() {
            console.log("Error loading user list");
        });
    }

    function replyMessage(event) {
        let currentId = event.currentTarget.getAttribute("Id").split("-")[1];
        let caption = $(`#toastSender-${currentId}`).text().trim();
        let ind = caption.indexOf(':');
        let sender = caption.substr(0, ind);
        let subject = caption.substr(ind+1).trim();

        $('#subject').val(`Fwd: ${subject}`);
        
        for(let user of $('#list-group-users').children()) {
            if(user.innerText == sender) {
                user.children[0].checked = true;
            }
        }
        $('#messageText').focus();
        $(`#btnClose-${currentId}`).click();
    }

    function loadNewMessages() {
        $.ajax({
            type: "POST",
            url: msg_server,
            data: {query:"load"},
            success: function(retr){
                let msgs = retr.data;
                for(let msg of msgs) {
                    msg_number++;
                    $("#toastPlacement").append(createToast(msg));
                    $(`#btnReply-${msg_number}`).click(replyMessage);
                }
            },
            dataType: "json"
        }).fail(function () {
            console.log("error");
        });
    }

    function sendMessage(msg) {
        $.ajax({
            type: "POST",
            url: msg_server,
            data: {query:"send", data: msg},
            success: function(retr){
            },
            dataType: "json"
        }).fail(function (err) {
            console.log(JSON.stringify(err));
            showAlert("danger",
                    `An error occurred while sending the message to ${(userList.filter(u => u.id == msg[0].value))[0].username}`
                    );
        });
    }

    function showAlert(alertType, alertMessage) {
        const alertPlaceholder = document.getElementById('liveAlertPlaceholder');
        var wrapper = document.createElement('div');
        wrapper.innerHTML = '<div id="alert" class="alert alert-' + alertType + ' alert-dismissible" role="alert">' +
            alertMessage + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        alertPlaceholder.append(wrapper);
        window.setTimeout(function() {
            $('#alert').alert('close');
        }, 5000);
    }

    function senderFormClick() {
        let data = $(this).serializeArray();
        let subject = $('#subject').val();
        let message = $('#messageText').val();
        let flag = false;

        // Send message to users
        for(let item of $('#list-group-users').children()) {
            
            let user = item.children[0];
            if(user.checked) {
                sendMessage({
                    "id": user.value, 
                    "subject": subject, 
                    "message": message
                });
                // console.log(user);
                flag = true;
            }
            user.checked = false;
        }
        if(flag) {
            $('#selectAll').prop("checked", false);
            $('#subject').val('');
            $('#messageText').val('');
            showAlert("success", "Message sent");
            $('#no-user').hide();
        } else {
            $('#no-user').show();
        }
        
    }

    function onSelectAll(event) {
        for(let user of $('.form-check-input')) {
            user.checked = event.currentTarget.checked;
        }
    }

    function userListFilter(event) {
        let name = event.currentTarget.value;
        for(let item of $('#list-group-users').children()) {
            if(!item.innerText.trim().toUpperCase().startsWith(name.toUpperCase())) {
                $(item).hide();
            } else {
                $(item).show();
            }
        }
    }
    
    $(document).ready(function () {

        $('#senderForm').submit((event) => {
            event.preventDefault();
            senderFormClick(); 
        });

        $('#selectAll').click(onSelectAll);

        $('#userFilter').keyup(userListFilter);

        $('#subject').focus();
        
        getUserList();
        loadNewMessages();
        setInterval(loadNewMessages, 5000);
 
    });
    

})();
