<?php

if (isset($_POST['submit'])) {
	
	include_once 'dbh.inc.php';

	$c_name=mysqli_real_escape_string($conn, $_POST['c_name']);
	$c_no=mysqli_real_escape_string($conn, $_POST['c_no']);
	$sem=mysqli_real_escape_string($conn, $_POST['sem']);
	$credits=mysqli_real_escape_string($conn, $_POST['credits']);
	$dept=mysqli_real_escape_string($conn, $_POST['dept']);

	//Error handlers
	//Check for empty fields
	if (empty($c_name) || empty($c_no) || empty($sem) || empty($credits) ) {
		header("Location: ../admin.php?admin=empty");
		exit();
	} else{
		//Check if input characters are valid
		if (!preg_match("/^[0-9]*$/", $sem) || !preg_match("/^[0-9]*$/", $credits) ) {
			header("Location: ../admin.php?admin=invalid");
			exit();
		}
			 else{
				$sql = "SELECT * FROM course WHERE c_name='$c_name'";
				$result = mysqli_query($conn, $sql);
				$resultCheck =  mysqli_num_rows($result);

				if ($resultCheck > 0) {
					header("Location: ../admin.php?admin=taken");
					exit();
				} else{
					$sql = "INSERT INTO course (c_name,c_no,sem,credits,dept) VALUES ('$c_name','$c_no','$sem','$credits','$dept');";
					mysqli_query($conn, $sql);
					$price1 = 125;
					$price2 = 400;
					$price3 = $credits*1000;
					$price4 = 5000;
					$sql1 = "SELECT c_id FROM course WHERE c_name='$c_name'";
					$result1 = mysqli_query($conn, $sql1);
					$result2 = mysqli_fetch_assoc($result1);
					$result3 = $result2['c_id'];
					$resultCheck1 = mysqli_num_rows($result1);
					if ($resultCheck1 > 1)
					{
					 	header("Location: ../admin.php?admin=typetaken");
						exit();
					} 
					else
					{
						$insert1="INSERT INTO rtype (c_id,type,price) VALUES ('$result3','makeup','$price1')";
						$insert2="INSERT INTO rtype (c_id,type,price) VALUES ('$result3','reval','$price2')";
						$insert3="INSERT INTO rtype (c_id,type,price) VALUES ('$result3','fastrack','$price3')";
						$insert4="INSERT INTO rtype (c_id,type,price) VALUES ('$result3','challange reval','$price4')";
						mysqli_query($conn, $insert1);
						mysqli_query($conn, $insert2);
						mysqli_query($conn, $insert3);
						mysqli_query($conn, $insert4);
					}
					header("Location: ../admin.php?admin=success");
					exit();
				}
			}
		}

}  else{
	header("Location: ../admin.php?admin=error");
	exit();
}