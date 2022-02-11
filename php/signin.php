<?php

require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $username = trim($_POST["username"]);
  $password = trim($_POST["password"]);

  if(empty($username_err) && empty($password_err)) {

    $sql = "SELECT id, username, password, active FROM users WHERE username = ?";
    
    if($stmt = $mysqli->prepare($sql)) {

      $stmt->bind_param("s", $param_username);
      $param_username = $username;
      
      if($stmt->execute()) {
        
        $stmt->store_result();
        
        if($stmt->num_rows == 1) {
          
          $stmt->bind_result($id, $username, $hashed_password, $userstate);
          
          if($stmt->fetch()) {
            // echo $id, $username, $password, $userstate;
            if(password_verify($password,$hashed_password)) {
              
              if ($userstate) {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $id;
                $_SESSION["username"] = $username;
                $stmt->close();

                // change last login date
                $sql = "UPDATE users SET lastlogin = ? WHERE id = ?";

                if($stmt = $mysqli->prepare($sql)) {
                  $stmt->bind_param("si", $param_lastlogin, $param_id);
                  $param_id = $id;
                  $param_lastlogin = date("Y-m-d H:i:s");
                  $stmt->execute();
                }
                $stmt->close();
                $mysqli->close();

                header("Location: userlist.php");
                exit;
              }
              else {
                $username_err = "User '$username' is blocked";
              }
              
            } else {
              $password_err = "Invalid username or password";
            }
          }
        } else {
          $username_err = "Invalid username.";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later";
      }

      $stmt->close();
    }
  }
  $mysqli->close();
}

$title="Signin";
include("../html/header.html");
?>

<body class="text-center">
    
  <main class="form-signin">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
      <div class="form-floating">
        <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"
            id="floatingName" name="username" placeholder="User name" required autofocus>
        <label for="floatingName">User name</label>
        <span class="invalid-feedback"><?php echo $username_err; ?></span>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
            id="floatingPassword" name="password" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
      <p class="login-wrapper-footer-text">Don't have an account yet? <a href="signup.php" class="text-reset">Signup here</a></p>
    </form>
    <p class="mt-5 mb-3 text-muted">Test Itransition© 2022</p>
  </main>

</body>
<!-- Custom styles for this template -->
<link href="../css/signin.css" rel="stylesheet">