<?php
  session_start();


  $Email = $_POST['Email'];
  $Address = $_POST['Address'];
  $pDate = $_POST['pDate'];
  $Days = $_POST['Days'];
  $cars = $_POST['cars'];



  $conn = new mysqli('localhost', 'id15606831_root','8%0jyBdferA|IHpN','id15606831_demo');
  if($conn->connect_error){
    echo "$conn->connect_error";
    echo "hello";
    die("Connection Failed: ".$conn->connect_error);
  } else{


    $sql = "INSERT INTO booking_table (Address, pDate, Days, cars, Email)
     VALUES ('$Address','$pDate','$Days','$cars','$Email')";
     echo '<script type="text/javascript"> alert('.$Email.')</script>';
     $_SESSION['Email'] = $Email;
     $_SESSION['Address'] = $Address;
     $_SESSION['pDate'] = $pDate;
     $_SESSION['Days'] = $Days;
     $_SESSION['cars'] = $cars;


     if (mysqli_query($conn, $sql)) {
        // "Your car is booked !";
        echo'<script>window.location="welcome.php"</script>';
     } else {
        echo "Error: " . $sql . ":-" . mysqli_error($conn);
     }



     mysqli_close($conn);



  }


 ?>
