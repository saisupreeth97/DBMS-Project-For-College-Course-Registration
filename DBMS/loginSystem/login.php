<?php  
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	$sess=$_SESSION['u_uid'];
	if (!isset($_SESSION['u_id'])) 
	{
		header("Location: index.php");	
	 	exit();
	}
	if (($sess=="1BM15IS034") || ($sess=="1BM15IS016")) 
	{
		header("Location: admin.php");
		exit();
	}
?>


<form method="POST">
		<select name="sem">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
		</select>
		<select name="dept">
			<option value="NONE">NONE</option>
			<option value="ISE">ISE</option>
			<option value="CSE">CSE</option>
			<option value="ECE">ECE</option>
			<option value="MECH">MECH</option>
			<option value="IT">IT</option>
			<option value="CIVIL">CIVIL</option>
			<option value="BIO">BIO</option>
		</select>
		<section class="main-container">
 			<div class="main-wrapper button-lgn"><form method="POST">
				<button name="but-m">Makeup</button>
				<button name="but-r">Reval</button>
				<button name="but-f">Fastrack</button>
				<button name="but-cr">Challange Reval</button>
			</div>
		</section>
	</form>

<?php
	if (isset($_POST['but-m'])) 
	{
		$sval = $_POST['sem'];
		$sem = (int)$sval;
		$dept = $_POST['dept'];
		$sql = "SELECT course.c_name,course.c_no,course.credits,rtype.price,rtype.r_id FROM course,rtype WHERE rtype.c_id=course.c_id AND sem='$sem' AND dept='$dept' AND type='makeup' ";
		$result=mysqli_query($conn, $sql);
		$numResult = mysqli_num_rows($result);
		if ($numResult > 0) 
		{
?>
<form method="POST">
<div class="atable">
<table>
	<tr><th>Select</th><th>Course Name</th><th>Course Number</th><th>Credits</th><th>Price</th></tr>
<?php
			while ($row = mysqli_fetch_assoc($result))
			{
				$val = $row['r_id'];
?>		
		<tr>
			<td><input type="checkbox" name="subjects[]" value="<?php echo $val; echo ","; echo $row['price']; ?>"></td>
			<td><?php echo $row['c_name'];?></td>
			<td><?php echo $row['c_no'];?></td>
			<td><?php echo $row['credits'];?></td>
			<td><?php echo $row['price'];?></td>
		</tr>
<?php
			}
?>
	</table>
	<p>Choose Payment Method</p>
	<p><input type="radio" name="paytm"><img src="paytm.png" height="100px" width="100px"></p>
	<p><input type="radio" name="paypal"><img src="paypal.png" height="70px" width="100px"></p>
	<button type="submit" name="val-subm" class="sbform1">SUBMIT</button>
</form>
</div>
<?php
		}
	}
	if (isset($_POST['val-subm'])) 
	{
		if (!empty($_POST['subjects'])) 
		{
			$total_price=0;
			$test = $_POST['subjects'];
			$us_id = $_SESSION['u_id'];
			$len=sizeof($test);
			if($len >= 4)
			{
				$total_price = 400;
			}
			else
			{
				for($i=0;$i<$len;$i++)
				{
					$array = explode(',',$test[$i]);
					$price = (int)$array[1];
					$total_price += $price;
				}
			}
			for($x=0;$x<$len;$x++)
			{
				$myarray = explode(',',$test[$x]);
				$rid = (int)$myarray[0];
				$price = (int)$myarray[1];
				$sql = "INSERT INTO register(r_id,user_id,price) VALUES ('$rid','$us_id','$price')";
				mysqli_query($conn, $sql);
			}
			$sql1 = "INSERT INTO p_register(user_id,nos,type,t_price) VALUES ('$us_id','$len','makeup','$total_price')";
			mysqli_query($conn, $sql1);
			echo "REGISTERED SUCESSFULLY";
		}
		else
		{
			header("Location: login.php");
		}
	}
?>

<!--REVAL-->

<?php
	if (isset($_POST['but-r'])) 
	{
		$sval = $_POST['sem'];
		$sem = (int)$sval;
		$dept = $_POST['dept'];
		$sql = "SELECT course.c_name,course.c_no,course.credits,rtype.price,rtype.r_id FROM course,rtype WHERE rtype.c_id=course.c_id AND sem='$sem' AND dept='$dept' AND type='reval' ";
		$result=mysqli_query($conn, $sql);
		$numResult = mysqli_num_rows($result);
		if ($numResult > 0) 
		{
?>
<form method="POST">
<div class="atable">
<table>
	<tr><th>Select</th><th>Course Name</th><th>Course Number</th><th>Credits</th><th>Price</th></tr>
<?php
			while ($row = mysqli_fetch_assoc($result))
			{
				$val = $row['r_id'];
?>		
		<tr>
			<td><input type="checkbox" name="subjects[]" value="<?php echo $val; echo ","; echo $row['price']; ?>"></td>
			<td><?php echo $row['c_name'];?></td>
			<td><?php echo $row['c_no'];?></td>
			<td><?php echo $row['credits'];?></td>
			<td><?php echo $row['price'];?></td>
		</tr>
<?php
			}
?>
	</table>
	<button type="submit" name="val-subr" class="sbform1">SUBMIT</button>
</form>
</div>
<?php
		}
	}
	if (isset($_POST['val-subr'])) 
	{
		if (!empty($_POST['subjects'])) 
		{
			$total_price=0;
			$test = $_POST['subjects'];
			$us_id = $_SESSION['u_id'];
			$len=sizeof($test);
			for($i=0;$i<$len;$i++)
			{
				$array = explode(',',$test[$i]);
				$price = (int)$array[1];
				$total_price += $price;
			}
			for($x=0;$x<$len;$x++)
			{
				$myarray = explode(',',$test[$x]);
				$rid = (int)$myarray[0];
				$price = (int)$myarray[1];
				$sql = "INSERT INTO register(r_id,user_id,price) VALUES ('$rid','$us_id','$price')";
				mysqli_query($conn, $sql);
			}
			$sql1 = "INSERT INTO p_register(user_id,nos,type,t_price) VALUES ('$us_id','$len','reval','$total_price')";
			mysqli_query($conn, $sql1);
			echo "REGISTERED SUCESSFULLY";
		}
		else
		{
			header("Location: login.php");
		}
	}
?>

<!--Fastrack-->

<?php
	if (isset($_POST['but-f'])) 
	{
		$sval = $_POST['sem'];
		$sem = (int)$sval;
		$dept = $_POST['dept'];
		$sql = "SELECT course.c_name,course.c_no,course.credits,rtype.price,rtype.r_id FROM course,rtype WHERE rtype.c_id=course.c_id AND sem='$sem' AND dept='$dept' AND type='fastrack' ";
		$result=mysqli_query($conn, $sql);
		$numResult = mysqli_num_rows($result);
		if ($numResult > 0) 
		{
?>
<form method="POST">
<div class="atable">
<table>
	<tr><th>Select</th><th>Course Name</th><th>Course Number</th><th>Credits</th><th>Price</th></tr>
<?php
			while ($row = mysqli_fetch_assoc($result))
			{
				$val = $row['r_id'];
?>		
		<tr>
			<td><input type="checkbox" name="subjects[]" value="<?php echo $val; echo ","; echo $row['price']; echo ","; echo $row['credits']; ?>"></td>
			<td><?php echo $row['c_name'];?></td>
			<td><?php echo $row['c_no'];?></td>
			<td><?php echo $row['credits'];?></td>
			<td><?php echo $row['price'];?></td>
		</tr>
<?php
			}
?>
	</table>
	<button type="submit" name="val-subf" class="sbform1">SUBMIT</button>
</form>
</div>
<?php
		}
	}
	if (isset($_POST['val-subf'])) 
	{
		if (!empty($_POST['subjects'])) 
		{
			$total_price=0;
			$test = $_POST['subjects'];
			$us_id = $_SESSION['u_id'];
			$len=sizeof($test);
			$t_credits = 0;
			for($z=0;$z<$len;$z++)
			{
				$array1 = explode(',',$test[$z]);
				$credits = (int)$array1[2];
				$t_credits+=$credits;
			}
			if ($t_credits > 12) 
			{
				echo "YOU ARE NOT ALLOWED TO REGISTER MORE THAN 12 CREDITS";
				echo '</br>';
				echo '<a href="login.php"><button type="submit">Click here to go back!!</button></a>';
			}
			else {
			for($i=0;$i<$len;$i++)
			{
				$array = explode(',',$test[$i]);
				$price = (int)$array[1];
				$total_price += $price;
			}
			for($x=0;$x<$len;$x++)
			{
				$myarray = explode(',',$test[$x]);
				$rid = (int)$myarray[0];
				$price = (int)$myarray[1];
				$sql = "INSERT INTO register(r_id,user_id,price) VALUES ('$rid','$us_id','$price')";
				mysqli_query($conn, $sql);
			}
			$sql1 = "INSERT INTO p_register(user_id,nos,type,t_price) VALUES ('$us_id','$len','fastrack','$total_price')";
			mysqli_query($conn, $sql1);
			echo "REGISTERED SUCESSFULLY";
			}
		}
		else
		{
			header("Location: login.php");
		}
	}
?>

<!--CHALLANGE REVAL-->

<?php
	if (isset($_POST['but-cr'])) 
	{
		$sval = $_POST['sem'];
		$sem = (int)$sval;
		$dept = $_POST['dept'];
		$sql = "SELECT course.c_name,course.c_no,course.credits,rtype.price,rtype.r_id FROM course,rtype WHERE rtype.c_id=course.c_id AND sem='$sem' AND dept='$dept' AND type='challange reval' ";
		$result=mysqli_query($conn, $sql);
		$numResult = mysqli_num_rows($result);
		if ($numResult > 0) 
		{
?>
<form method="POST">
<div class="atable">
<table>
	<tr><th>Select</th><th>Course Name</th><th>Course Number</th><th>Credits</th><th>Price</th></tr>
<?php
			while ($row = mysqli_fetch_assoc($result))
			{
				$val = $row['r_id'];
?>		
		<tr>
			<td><input type="checkbox" name="subjects[]" value="<?php echo $val; echo ","; echo $row['price']; ?>"></td>
			<td><?php echo $row['c_name'];?></td>
			<td><?php echo $row['c_no'];?></td>
			<td><?php echo $row['credits'];?></td>
			<td><?php echo $row['price'];?></td>
		</tr>
<?php
			}
?>
	</table>
	<button type="submit" name="val-subcr" class="sbform1">SUBMIT</button>
</form>
</div>
<?php
		}
	}
	if (isset($_POST['val-subcr'])) 
	{
		if (!empty($_POST['subjects'])) 
		{
			$total_price=0;
			$test = $_POST['subjects'];
			$us_id = $_SESSION['u_id'];
			$len=sizeof($test);
			for($i=0;$i<$len;$i++)
			{
				$array = explode(',',$test[$i]);
				$price = (int)$array[1];
				$total_price += $price;
			}
			for($x=0;$x<$len;$x++)
			{
				$myarray = explode(',',$test[$x]);
				$rid = (int)$myarray[0];
				$price = (int)$myarray[1];
				$sql = "INSERT INTO register(r_id,user_id,price) VALUES ('$rid','$us_id','$price')";
				mysqli_query($conn, $sql);
			}
			$sql1 = "INSERT INTO p_register(user_id,nos,type,t_price) VALUES ('$us_id','$len','reval','$total_price')";
			mysqli_query($conn, $sql1);
			echo "REGISTERED SUCESSFULLY";
		}
		else
		{
			header("Location: login.php");
		}
	}
?>
