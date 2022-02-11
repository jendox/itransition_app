<?php

require_once "checklogin.php";
require_once "config.php";

if (isset($_POST['check'])) {
    $ids_list = array_keys($_POST['check']);
    $sql = "UPDATE users SET active = ? WHERE id = ?";
    if($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ii", $param_active, $param_id);
        $param_active = 1;
        foreach($ids_list as $id) {
            $param_id = (int)$id;
            $stmt->execute();
        }
        $stmt->close();
        $mysqli->close();
    }
}

header("Location: userlist.php");
exit;

?>