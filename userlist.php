<?php require_once "checklogin.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User list</title>
  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="css/userlist.css" rel="stylesheet">
</head>
<body>
    <?php include("html/navbar.html"); ?>

    <div class="containger-flexible" id="containerUsers">
      <form class="form-users">
        <?php include("html/userlisttoolbar.html"); ?>
        <table class="table caption-top">

          <?php include("html/tablehead.html"); ?>
          
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
                  include("html/tablerow.html");
                }
                $result->close();
              }
              $mysqli->close();
            ?>
          </tbody>
        </table>
      </form>
    </div>
    <script src="js/main.js"></script>
</body>