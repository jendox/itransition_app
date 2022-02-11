<?php
require_once "checklogin.php";
$title = "User list";
include("../html/header.html");
?>


<body>
    <?php include("../html/navbar.html"); ?>

    <div class="containger-flexible" id="containerUsers">
      <form class="form-users">
        <?php include("../html/userlisttoolbar.html"); ?>
        <table class="table caption-top">

          <?php include("../html/tablehead.html"); ?>
          
          <tbody>
            <?php
              require_once "config.php";

              $result = $mysqli->query("SELECT * FROM users");
              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  if($row["active"] == 1) {
                    $status = "Active";
                    if($row["id"] == $_SESSION["id"]) {
                      $tablecls = "table-info";
                    } else {
                      $tablecls = "table-success";
                    }
                  } else {
                    $status = "Blocked";
                    $tablecls = "table-danger";
                  }
                  include("../html/tablerow.html");
                }
                $result->close();
              }
              $mysqli->close();
            ?>
          </tbody>
        </table>
      </form>
    </div>
</body>
<!-- Custom styles for this template -->
<link href="../css/userlist.css" rel="stylesheet">
<script src="../js/main.js"></script>