<?php
// Initialize the session
session_start();



// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <!--<style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>-->
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
    <link rel="stylesheet" href="generalpagestyle.css">

    <style>
      .heading{
        color: white;
        font-size: 3rem;
      }
      table {
        border: 0px solid #808080;
        width: 110%;
        font-size: 1.5rem;
      }

      tr td:last-child {
        height: 50px;
        //white-space: pre-wrap;
        
      }
      #clickables{
        font-size: 1.2rem;
      }
    </style>

</head>
<body style="background-color: #1b262c;">
  <div class="container">


    <div class="page-header">
        <h1 class="heading">Hi, <b><?php echo htmlspecialchars($_SESSION["email"]); ?></b>. Welcome to ApniGaadi</h1>
    </div>
    <p style="color: red;">
        <a href="reset-password.php" class="btn btn-warning" id="clickables">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger" id="clickables">Sign Out of Your Account</a>
        <a href="carspage.html" class="btn btn-primary" id="clickables">Book Car</a>
        <a href="contactus.html" class="btn btn-success" id="clickables">Contact Us</a>
        <a href="faq.html" class="btn btn-info" id="clickables">FAQs</a>

        <br><br>

        <div class="container">
          <div class="row col-md-6 col-md-offset-3">
            <div class="card" style="width: 500rem;">
                  <div class="card-body">

        <p>
        <?php
        $conn = new mysqli('localhost', 'id15606831_root','8%0jyBdferA|IHpN','id15606831_demo');
        if($conn->connect_error){
          echo "$conn->connect_error";
          echo "hello";
          die("Connection Failed: ".$conn->connect_error);
        }else{
          $sql = "SELECT * FROM booking_table WHERE email='{$_SESSION['email']}'";
          $sql1 = "SELECT Rate FROM cars WHERE Name='{$_SESSION['email']}'";
          $result=mysqli_query($conn,$sql);
          /*$result1=mysqli_query($conn,$sql1);
            while($res1 = mysqli_fetch_array($result1)){*/
          while($res = mysqli_fetch_array($result)){


          ?>

          <table style="color: black;" border="0">
          <tr>
          <th> Address</th>
          <th> Pickup Date</th>
          <th> Days</th>
          <th> Car</th>
          <th> Email</th>
          <!--<th> Rate</th>-->

          <tr>
          <td><?php echo $res['Address']; ?></td>
          <td><?php echo $res['pDate']; ?></td>
          <td><?php echo $res['Days']; ?></td>
          <td><?php echo $res['cars']; ?></td>
          <td><?php echo $res['email']; ?></td>
          <!--<td><?php echo $res1['Rate']; ?></td>-->

          </tr>
          </table>

          <?php
          }}


         ?>
         </p>
       </div>
     </div>
   </div>

</div>

    </p>

  </div>
</body>
</html>
