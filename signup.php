<?php

	session_start();

	$Username = $_POST['Username'];
	$email = $_POST['email'];

	// Database connection
	if (!empty($Username)|| !empty(Password)) {
		$host = "localhost";
		$dbUsername = "root";
		$dbPassword = "";
		$dbname = "test";

		$errors = array();


		$conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

		//register users
		$Username = mysqli_real_escape_string($conn,$_POST['Username']);
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$Password_2 = mysqli_real_escape_string($conn,$_POST['Password_2']);
		$Password_1 = mysqli_real_escape_string($conn,$_POST['Password_1']);

		//form validation
		if(empty($Username))
			{array_push($errors, "Username is required");}
		if(empty($email))
			{array_push($errors, "email is required");}
		if(empty($Password_1))
			{array_push($errors, "Password is required");}
		if($Password_2 != $Password_1)
			{array_push($errors,"Passwords need to be the same!");}

		//check db for existing user with same username
		$user_check_query = "SELECT * FROM user username = '$Username' or email = '$email' LIMIT 1";

		$results = mysqli_query($conn, $user_check_query);
		$user = mysqli_fetch_assoc($results);

		if($user){
			if($user['Username'] === $Username){array_push($error, "Username already exixts");}
			if($user['email'] === $email){array_push($error, "This email id already has a registered username");}


		}

		//register the user if no error
		if(count($error) == 0){
			$Password = md5($Password_1); //encrypt password
			$query = "INSERT INTO user(Username,email,Password) VALUES ('$Username','$email','$Password')";
			mysqli_query($conn,$query);
			$_SESSION['Username'] = $Username;
			$_SESSION['sucess'] = "You are now logged in!";

			//header('location: profile.html');

		}


		//login user
		if(isset($_POST['login_user'])){
			$Username = mysqli_real_escape_string($conn,$_POST['Username']);
			$Password = mysqli_real_escape_string($conn,$_POST['Password_1']);


			if(empty($Username)){
				array_push($errors, "Username is required");
			}

			if(empty($Password)){
				array_push($errors, "Password is required");
			}

			if(count($errors) == 0){
				$Password = md5($Password);

				$query = "SELECT * FROM user WHERE Username = '$Username' AND Password = '$Password'";

				$results= mysqli_query($conn,$query);


				if(mysqli_num_rows($results)) {
					$_SESSION['Username'] = $Username;
					$_SESSION['scucess'] = "Logged in successfully";

					header('location : profile.html');

				}else{
					array_push($errors, "Wrong Username or Password combination. Try again!");
				}
			}

		}







		//if($conn->connect_error){
		//	echo "$conn->connect_error";
		//	die("Connection Failed : ". $conn->connect_error);
		//} else {
		//	$stmt = $conn->prepare("insert into login(Username,email,Password) values(?, ?, ?)");
		//	$stmt->bind_param("sss", $Username, $Password, $email);
		//	$execval = $stmt->execute();
		//	echo $execval;
		//	echo "Logged In....";
		//	$stmt->close();
		//	$conn->close();
		}
?>
