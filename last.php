<?php
 session_start();
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
    <link rel="stylesheet" href="homepagestyle.css">

    <style>
      .heading{
        color: white;
      }
    </style>

</head>
<body style="background-color: #1b262c;">
  <div class="container">


    <div class="page-header">
        <h1 class="heading">Your booking details</h1>
    </div>
    <label><?php echo "Email: ".$_SESSION['Email'] ;
      

    ?></label>

  </div>
</body>
</html>
