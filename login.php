<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: welcome.php");
  exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
     <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
     <!-- Bootstrap links -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

     <!-- Google Fonts links -->
     <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500&family=PT+Sans&display=swap" rel="stylesheet">

     <!-- Font Awesome links -->
     <script src="https://kit.fontawesome.com/b855813eb8.js" crossorigin="anonymous"></script>

     <!-- Local stylesheet-->
     <link rel="stylesheet" href="homepagestyle.css">

</head>
<body>

  <body style="background-color: #1b262c;">
    <div class="container">
      <!-- Header -->
      <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="registration.php">
          <h1 class="heading">ApniGaadi.com</h1>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="contactus.html">Contact Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="registration.php">Sign Up</a>
            </li>
          </ul>
        </div>
      </nav>


<br>

    <!--<div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="page-header">
                    <h2></h2>
                </div>-->
                <div class="container">
                  <div class="row">
                    <!-- Signup Box -->
                    <div class="col-lg-6">
                      <div class="card" style="width: 27rem; background-color: #e5e5e5;" id="search-box">
                        <div class="card-body">

                <h3>Login</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="someone@email.com">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-dark" value="Login">
            </div>
            <p>Don't have an account? <a href="registration.php">Sign up now</a>.</p>
        </form>
            </div>
        </div>
    </div>
<br>
    <div class="col-lg-6" style="color: white;">
      <h3>Car Hire – Search, Compare & Save</h3><br>
      <div class="right-card">
        <i class="far fa-check-circle"> Price Match Guarantee</i><br>
        <i class="far fa-check-circle"> Free cancellations on most bookings</i><br>
        <img src="web.png" alt="car" width="550px">
      </div>
    </div>
    <div class="col-lg-6">

    </div>
  </div>
</div>
<br>
<br>

    <br>
    <hr>
    <br><br>
    <div class="container" id="bottom-container">
      <nav class="navbar navbar-expand-lg navbar-dark ">
        <a class="navbar-brand" href="">
          © 2020 ApniGaadi.com
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="">
                <a class="footer-link" href="https://www.facebook.com/apni.gaadi.9"><i class="fab fa-facebook-f" id="icons"></i></a>
                <a class="footer-link" href="https://twitter.com/ApniGaadi"><i class="fab fa-twitter" id="icons"></i></a>
                <a class="footer-link" href="https://www.instagram.com/apni_gaadi"><i class="fab fa-instagram" id="icons"></i></a>
              </a>
            </li>
          </ul>
        </div>
      </nav>







    </div>
    </div>




</body>
</html>
