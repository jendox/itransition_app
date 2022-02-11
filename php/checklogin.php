<?php

require_once "config.php";
session_start();

if(!isset($_SESSION["loggedin"])) {
    header("location: signin.php");
    exit;
    
} else {
    try {
        $sql = "SELECT active FROM users WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $param_id);
        $param_id = (int)$_SESSION["id"];
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($status);
        $stmt->fetch();
        $stmt->close();
        if(!$status) {
            throw new Exception("User is blocked");
        }
    } catch(Exception $e) {
        header("location: logout.php");
        exit;
    }
    
}

?>