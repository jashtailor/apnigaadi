<?php
	$Name = $_POST['Name'];
	$Email = $_POST['Email'];
	$Impressions = $_POST['Impressions'];
	$Hear = $_POST['Hear'];
	$Missing = $_POST['Missing'];
	$Recommend = $_POST['Recommend'];
  $Comments = $_POST['Comments'];

	// Database connection
	$conn = new mysqli('localhost','id15606831_root','8%0jyBdferA|IHpN','id15606831_demo');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ".$conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into feedbackform(Name, Email, Impressions, Hear, Missing, Recommend, Comments) values(?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("sssssss", $Name, $Email, $Impressions, $Hear, $Missing, $Recommend, $Comments);
		$execval = $stmt->execute();
		//echo $execval;
		//echo "Feedback submitted";
		header("Location: contactus.html");
		$stmt->close();
		$conn->close();
	}
?>
