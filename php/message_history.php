<?php
require_once "checklogin.php";
$title = "History";
include("../html/header.html");
?>

<body>
  <?php include("../html/navbar.html"); ?>
  <div class="container-sm py-3 px-3">
        <?php include("history_form.php"); ?>
  </div>
</body>

</html>

<link href="../css/messageitem.css" rel="stylesheet">
