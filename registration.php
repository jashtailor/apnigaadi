<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

            // Set parameters
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
    <title>ApniGaadi.com - Cheap Car Rental, Best Price Guarantee!</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
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
<body style="background-color: #1b262c;">
  <div class="container">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="homepage.html">
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
            <a class="nav-link" href="login.php">Sign In</a>
          </li>
        </ul>
      </div>
    </nav>



    <!-- COVID-19 alert -->
    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      Why choose car rental during Coronavirus (COVID-19)?
      Flexible bookings. Enhanced cleaning. <a href="findmore.html">Find out more</a>
    </div>
    <br>


    <!--<div class="container">
        <div class="row">


            <div class="col-lg-8 col-offset-2">
                <div class="page-header">
                    <h2></h2>
                </div>-->
                <div class="container">
                  <div class="row">
                    <!-- Signup Box -->
                    <div class="col-lg-6">
                      <div class="card" style="width: 27rem; background-color: #e5e5e5;" id="search-box">
                        <div class="card-body">

                <h3>Sign up</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" placeholder="someone@email.com">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-outline-dark" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>            </div>
        </div>
    </div>
  <br />
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
<hr><br>

<div class="container py-3">
  <div class="row">
    <div class="col-10 mx-auto">
      <div class="accordion" id="faqExample">
        <div class="card">
          <div class="card-header p-2" id="headingOne">
            <h2>Frequently Asked Questions</h2>
            <br><br>
            <h5 class="mb-0">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="faq">
                Q: What do I need to hire a car?
              </button>
            </h5>
          </div>

          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#faqExample">
            <div class="card-body">
              To book your car, all you need is a credit or debit card. When you pick the car up, you'll need:
              <br>
              <ul>
                <li>Your passport and Aadhar ID the car hire company needs to see.</li>
                <li>Each driver's full, valid driving licence, which they've held for at least 12 months (often 24).</li>
                <li>The main driver's credit / debit card, with enough available funds for the car's deposit.</li>
                <li>Your voucher / eVoucher, to show that you've paid for the car.</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-2" id="headingTwo">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="faq">
                Q: How old do I need to be to rent a car?
              </button>
            </h5>
          </div>
          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#faqExample">
            <div class="card-body">
              For most car hire companies, the age requirement is between 21 and 70 years old. If you're under 25 or over 70, you might have to pay an additional fee.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-2" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="faq">
                Q. Can I book a hire car for someone else?
              </button>
            </h5>
          </div>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
            <div class="card-body">
              Yes, as long as they meet these requirements. Just fill in their details while you're making the reservation.
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header p-2" id="headingThree">
            <h5 class="mb-0">
              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="faq">
                Q. Are all fees included in the rental price?
              </button>
            </h5>
          </div>
          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#faqExample">
            <div class="card-body">
              The vast majority of our rentals include Theft Protection, Collision Damage Waiver (CDW), local taxes, airport surcharges and any road fees. You'll pay for any ‘extras' when you pick your car up, along with any young driver,
              additional driver or one-way fees – but we'll explain any additional costs before you book your car (and taking your own child seats or GPS can be an easy way to reduce your costs). For more details on what's included, just check
              the Ts&Cs of any car you're looking at.
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <!--/row-->
</div>
<!--container-->
<br>
<hr>
<br><br>
<div class="container" id="bottom-container">
  <nav class="navbar navbar-expand-lg navbar-dark">
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
