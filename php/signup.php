<?php
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $email = "";
$username_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later";
            }

            // Close statement
            $stmt->close();
        }
    }

    //Validate email
    // Prepare a select statement
    $sql = "SELECT id FROM users WHERE email = ?";
    
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_email);
        
        // Set parameters
        $param_email = trim($_POST["email"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // store result
            $stmt->store_result();
            
            if($stmt->num_rows == 1){
                $email_err = "This email is already taken";
            } else{
                $email = trim($_POST["email"]);
            }
        } else{
            echo "Oops! Something went wrong. Please try again later";
        }

        // Close statement
        $stmt->close();
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: signin.php");
            } else{
                echo $username . ' ' . $email . ' ' . $_POST["password"] . '\n';
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}

$title="Signup";
include("../html/header.html");
?>

<body class="text-center">
    
    <main class="form-signup">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <h1 class="h3 mb-3 fw-normal">Please sign up</h1>
        <div class="form-floating">
            <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"
                id="floatingName" name="username" placeholder="User name" required autofocus>
            <label for="floatingInput">User name</label>
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>
        <div class="form-floating">
        <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"
                id="floatingEmail" name="email" placeholder="name@example.com" required>
        <label for="floatingInput">Email address</label>
        <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        <p class="login-wrapper-footer-text">Have an account? <a href="signin.php" class="text-reset">Signin</a></p>
        
    </form>
    <p class="mt-5 mb-3 text-muted">Test Itransition© 2022</p>
    </main>

</body>
<!-- Custom styles for this template -->
<link href="../css/signup.css" rel="stylesheet">