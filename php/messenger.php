<?php
require_once "checklogin.php";
$title = "Messages";
include("../html/header.html");
?>

<body>
  <?php include("../html/navbar.html"); ?>
  <div class="container-sm py-3 px-3" style="width: 45%;">
    <div class="row">
        <!-- Include messanger form -->
        <?php include("sender_form.php"); ?>
    </div>
    <div class="row">
      <div class="toast-container position-absolute p-3 bottom-0 start-50 translate-middle-x" id="toastPlacement" data-original-class="toast-container position-absolute p-3">
      </div>
    </div>
  </div>
  <?php
  //  include "../html/activeuser.html";
   ?>
  
</body>

<script src="../js/message-server.js"></script>