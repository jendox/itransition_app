<form id="senderForm" class="send-message py-0 px-4" action="" method="POST">
    <div class="col">
        <label for="user" class="form-label">User name</label>
        <select class="form-select" id="select-user" name="user" required>
            <option value="">Choose user...</option>
            <!-- Adding user list in select -->
            <?php
            $result = $mysqli->query("SELECT id, username FROM users");
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $id = $row["id"];
                    $username = $row["username"];
                    if($id != $_SESSION["id"]) {
                        include("../html/usernameopt.html");
                    }
                }
            }
            $result->close();
            ?>
        </select>
    </div>
        <div class="col-12 py-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required="">
            <!-- <div class="invalid-feedback">Please enter subject.</div> -->
        </div>

        <label class="mb-2" for="floatingTextarea">Message</label>
        <div class="form-floating">
            <textarea class="form-control" id="messageText" name="messageText" style="height: 100px" required></textarea>
        </div>

        <button class="w-100 btn btn-primary btn-lg mt-3 mb-2" id="btnSend" type="input">Send message</button>
        <div id="liveAlertPlaceholder"></div>
</form>