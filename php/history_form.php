<span class="fs-5 fw-semibold mt-5">Message history</span>
<div class="list-group list-group-flush border-bottom scrollarea"><br>
    <div class="accordion accordion-flush" id="accordionFlush">
    <?php
        $sql = "SELECT u.username sender, m.subject, m.message, m.send_time
            FROM messages m
            INNER JOIN users u
            ON m.send_id = u.id
            WHERE m.recp_id = ?";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $param_id);
        $param_id = (int)$_SESSION["id"];
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($sender, $subject, $message, $time);

        if($stmt->num_rows > 0) {
            $i = 0;
            while($stmt->fetch()) {
            include("../html/messageitem.html");
            $i++;
            }
            
        }
        $stmt->close();
        $mysqli->close();
    ?>
    </div>
</div>