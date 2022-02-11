<?php
require_once "checklogin.php";
$title = "Messages";
include("html/header.html");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User list</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <!-- <link href="css/signin.css" rel="stylesheet"> -->
    <style>
        .containger-flexible {
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
            padding-right: 20px;
        }
        .btn-image {
            width: 30px;
            height: 30px;
        }
    </style>
</head>
<body>
    <main>
      <nav class="navbar navbar-expand navbar-dark bg-dark" aria-label="Second navbar example">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
    
          <div class="collapse navbar-collapse" id="navbarsExample02">
            <ul class="navbar-nav me-auto">
              <li class="nav-item">
                <a class="nav-link text-muted" aria-current="page" href="userlist.php">User list</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="messages.php">Messages</a>
              </li>
            </ul>
            <form action="logout.php">
              <button class="btn btn-outline-danger" type="submit">Log out</button>
            </form>
          </div>
        </div>
      </nav>
      
    </main>
    <script src="js/main.js"></script>
</body>