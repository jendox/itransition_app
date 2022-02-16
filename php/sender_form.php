<form id="senderForm">
    <div class="row g-5">

        <div class="col order-md-last">
            <label for="user" class="form-label">User list</label>
            <input type="text" class="form-control" id="userFilter" placeholder="Type user name">
            <div class="pt-2 text-danger text-center" id="no-user" style="display: none">At least one user must be selected.</div>
            <div class="form-check pt-3">
                <input class="form-check-input me-2" type="checkbox" id="selectAll" value="">
                <p>Send to all</p>
            </div>
            <div class="list-group list-group-flush" id="list-group-users">
                
            </div>
        </div>
        
        <div class="col">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
            <label class="pt-2 mb-2" for="floatingTextarea">Message</label>
            <textarea class="form-control" id="messageText" name="messageText" style="height: 100px" required></textarea>
            <button class="w-100 btn btn-primary btn-lg mt-3 mb-2" id="btnSend" type="input">Send message</button>
            <div id="liveAlertPlaceholder"></div>

        </div>
    </div>
</form>
