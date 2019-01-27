<?php 
	include_once 'header.php';
	include_once 'includes/dbh.inc.php';
	$sess=$_SESSION['u_uid'];
	if (!isset($_SESSION['u_id'])) 
	{
		header("Location: index.php");	
		exit();
	}
	if(!(($sess=="1BM15IS034") || ($sess=="1BM15IS016")))
	{
		header("Location: login.php");	
		exit();
	}
 ?>
 <section class="main-container">
 <div class="main-wrapper button-adm"><form method="GET">
 	<div style="margin-left: 10px;">Select Department: <select name="dept">
		<option value="NONE">NONE</option>
		<option value="ISE">ISE</option>
		<option value="CSE">CSE</option>
		<option value="ECE">ECE</option>
		<option value="MECH">MECH</option>
		<option value="IT">IT</option>
		<option value="CIVIL">CIVIL</option>
		<option value="BIO">BIO</option>
	</select></div>
	<div style="margin-left: 235px;">Select Type: <select name="type">
		<option value="NONE">NONE</option>
		<option value="makeup">Makeup</option>
		<option value="reval">Reval</option>
		<option value="fastrack">Fastrack</option>
		<option value="challange reval">Challange Reval</option>
	</select></div>
</br>
</br>
	<button name="buttonSub">Add Subjects</button>
	<button name="buttonReg">Registered Students</button>
	<button name="buttonReg-price">Price</button>
</form></div></section>
<?php 
	if(isset($_GET['buttonSub']))
	{
		echo '<form class="sbform" action="includes/admin.inc.php" method="POST">
	<input type="text" name="c_name" placeholder="Enter Course Name" required>
	<input type="text" name="c_no" placeholder="Enter Course Number" required>
	<input type="text" name="sem" placeholder="Enter Sem" required>
	<input type="text" name="credits" placeholder="Enter Credits" required>
	<p>Select Department: <select name="dept">
		<option value="NONE">NONE</option>
		<option value="ISE">ISE</option>
		<option value="CSE">CSE</option>
		<option value="ECE">ECE</option>
		<option value="MECH">MECH</option>
		<option value="IT">IT</option>
		<option value="CIVIL">CIVIL</option>
		<option value="BIO">BIO</option>
	</select></p>
	<button type="submit" name="submit">SUBMIT</button>
</form>';
	}
	if (isset($_GET['buttonReg'])) 
	{
		$type = $_GET['type'];
		$dept = $_GET['dept'];
		$sql = "SELECT users.user_uid,users.user_first,users.user_last,course.c_name,course.c_no,rtype.type,course.dept,rtype.price FROM users,course,rtype,register WHERE rtype.r_id=register.r_id AND users.user_id=register.user_id AND rtype.c_id=course.c_id AND users.depart='$dept' AND rtype.type='$type' ";
		if($dept=="NONE")
		{
			$sql = "SELECT users.user_uid,users.user_first,users.user_last,course.c_name,course.c_no,rtype.type,course.dept,rtype.price FROM users,course,rtype,register WHERE rtype.r_id=register.r_id AND users.user_id=register.user_id AND rtype.c_id=course.c_id AND rtype.type='$type' ";
		}
		if ($type == "NONE") 
		{
			$sql = "SELECT users.user_uid,users.user_first,users.user_last,course.c_name,course.c_no,rtype.type,course.dept,rtype.price FROM users,course,rtype,register WHERE rtype.r_id=register.r_id AND users.user_id=register.user_id AND rtype.c_id=course.c_id AND users.depart='$dept'";
		}
		if($dept=="NONE" && $type=="NONE")
		{
			$sql = "SELECT users.user_uid,users.user_first,users.user_last,course.c_name,course.c_no,rtype.type,course.dept,rtype.price FROM users,course,rtype,register WHERE rtype.r_id=register.r_id AND users.user_id=register.user_id AND rtype.c_id=course.c_id";
		}
		$result = mysqli_query($conn, $sql);
		$numResult = mysqli_num_rows($result);
		?>
			<div class='atable'>
			<table>
			<tr>
				<th>USN</th>
				<th>FirstName</th>
				<th>LastName</th>
				<th>Course Name</th>
				<th>Course Number</th>
				<th>Type</th>
				<th>Dept</th>
				<th>Price</th>
			</tr>
		<?php
		if ($numResult > 0) 
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				?>
				<tr>
					<td><?php echo $row['user_uid']; ?></td>
					<td><?php echo $row['user_first']; ?></td>
					<td><?php echo $row['user_last']; ?></td>
					<td><?php echo $row['c_name']; ?></td>
					<td><?php echo $row['c_no']; ?></td>
					<td><?php echo $row['type']; ?></td>
					<td><?php echo $row['dept']; ?></td>
					<td><?php echo $row['price']; ?></td>
				</tr>
				<?php
			}	
		}
		echo "</table>";
		echo "</div>";
	}
	if (isset($_GET['buttonReg-price'])) 
	{
		$type = $_GET['type'];
		$dept = $_GET['dept'];
		$sql = "SELECT users.user_uid,users.user_first,users.user_last,p_register.nos,p_register.type,users.depart,p_register.t_price FROM users,p_register WHERE users.user_id=p_register.user_id AND users.depart='$dept' AND p_register.type='$type' ";
		$sql1 = "SELECT sum(p_register.t_price) as sum FROM users,p_register WHERE users.user_id=p_register.user_id AND users.depart='$dept' AND p_register.type='$type' group by users.depart,p_register.type";
		if ($type == "NONE") 
		{
			$sql = "SELECT users.user_uid,users.user_first,users.user_last,p_register.nos,p_register.type,users.depart,p_register.t_price FROM users,p_register WHERE users.user_id=p_register.user_id AND users.depart='$dept' ";
			$sql1 = "SELECT sum(p_register.t_price) as sum FROM users,p_register WHERE users.user_id=p_register.user_id AND users.depart='$dept' group by users.depart";
		}
		if ($dept == "NONE") 
		{
			$sql = "SELECT users.user_uid,users.user_first,users.user_last,p_register.nos,p_register.type,users.depart,p_register.t_price FROM users,p_register WHERE users.user_id=p_register.user_id AND p_register.type='$type' ";
			$sql1 = "SELECT sum(p_register.t_price) as sum FROM users,p_register WHERE users.user_id=p_register.user_id AND p_register.type='$type' group by p_register.type";
		}
		if ($type=="NONE" && $dept=="NONE") 
		{
			$sql = "SELECT users.user_uid,users.user_first,users.user_last,p_register.nos,p_register.type,users.depart,p_register.t_price FROM users,p_register WHERE users.user_id=p_register.user_id";
			$sql1 = "SELECT sum(p_register.t_price) as sum FROM users,p_register WHERE users.user_id=p_register.user_id ";
		}
		$result = mysqli_query($conn, $sql);
		$result1 = mysqli_query($conn, $sql1);
		$numResult = mysqli_num_rows($result);
		$numResult1 = mysqli_num_rows($result1);
		?>
			<div class='atable'>
			<table>
			<tr>
				<th>USN</th>
				<th>FirstName</th>
				<th>LastName</th>
				<th>No Of Subjects Registeres</th>
				<th>Type</th>
				<th>Dept</th>
				<th>Total Price</th>
			</tr>
		<?php
		if ($numResult > 0) 
		{
			while ($row = mysqli_fetch_assoc($result))
			{
				?>
				<tr>
					<td><?php echo $row['user_uid']; ?></td>
					<td><?php echo $row['user_first']; ?></td>
					<td><?php echo $row['user_last']; ?></td>
					<td><?php echo $row['nos']; ?></td>
					<td><?php echo $row['type']; ?></td>
					<td><?php echo $row['depart']; ?></td>
					<td><?php echo $row['t_price']; ?></td>
				</tr>
				<?php
			}
			if ($numResult1 > 0) 
			{
				$row1 = mysqli_fetch_assoc($result1);
				echo "TOTAL SUM:".$row1['sum'];		
			}	
		}
		echo "</table>";
		echo "</div>";
	}
 ?>
