<?php
require_once "checklogin.php";

if(!isset($_POST["query"])) {
    $mysqli->close();
    exit;
}

if($_POST["query"] == "load") {
    
    $sql = "SELECT m.id, u.username sender, m.subject, m.message, m.send_time
        FROM messages m
        INNER JOIN users u
        ON m.send_id = u.id
        WHERE m.recp_id = ? AND m.readed = FALSE";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $param_id);
    $param_id = (int)$_SESSION["id"];
    // $param_id = 7;
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($mid, $sender, $subject, $message, $time);

    if($stmt->num_rows > 0) {
        while($stmt->fetch()) {
            $data[] = array(
                "mid"=>$mid,
                "sender"=>$sender,
                "subject"=>$subject,
                "message"=>$message,
                "time"=>$time);
        }
        $stmt->close();
        $sql = "UPDATE messages SET readed = TRUE WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $param_id);
        foreach($data as $row) {
            $param_id = (int)$row["mid"];
            $stmt->execute();
        }
        $retr["data"] = $data;
    } else {
        $retr["data"] = array();
    }
    $stmt->close();
} elseif($_POST["query"] == "send") {
	if(isset($_POST["data"])) {
        $data = $_POST["data"];
        $sql_err = 0;
    
        $sql = "INSERT INTO messages (send_id, recp_id, subject, message) VALUES (?, ?, ?, ?)";
        if($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("iiss", $param_sid, $param_rid, $param_subject, $param_message);
            $param_sid = (int)$_SESSION["id"];
            $param_rid = (int)$data["id"];
            $param_subject = $data["subject"];
            $param_message = $data["message"];
            if($stmt->execute()) {
                $sql_err = $stmt->errno;
            }
            $stmt->close();
        } else {
            $sql_err = $mysqli->errno;
        }
    } else {
        $retr["status"] = "Error: No data to send";
    }
    $retr["status"] = $sql_err == 0 ? "ok" : "Error: $sql_err";
} elseif($_POST["query"] == "users") {
    $sql = "SELECT id, username FROM users";
    $result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        if ($row["id"] != $_SESSION["id"]) {
            $users[] = $row;
        }
    }
    $retr["data"] = $users;
} else {
    $retr["status"] = "Error: unknown query";
}


$mysqli->close();

header("Content-Type: application/json");
echo json_encode($retr);

?>