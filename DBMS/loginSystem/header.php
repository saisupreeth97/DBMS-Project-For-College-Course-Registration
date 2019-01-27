<?php
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<header>
	<nav>
		<div class="main-wrapper">
			<div id="img">
			<ul>
				<li><a href="index.php"><img src="bms_logo.png" height="65px;"></a></li>
			</ul>
			</div>
			<div class="nav-login">
				<?php 
					/*if (isset($_SESSION['u_id'])) {
						echo '<form action="includes/logout.inc.php" method="POST">
				 	          <button type="submit" name="submit">Logout</button>
				              </form>';
					} */
					if (isset($_SESSION['u_id'])) 
					{
						$sess = $_SESSION['u_id'];
						if (($sess == 1) || ($sess == 2)) 
						{
							echo '<form action="includes/logout.inc.php" method="POST">
				 	          <button type="submit" name="submit">Logout</button>
				              </form>';
						}
						else
						{	
							echo '<form action="login.php" method="POST">
				 	          <button type="submit" name="submit">Register</button>
				              </form>
								<form action="includes/logout.inc.php" method="POST">
				 	          <button type="submit" name="submit">Logout</button>
				              </form>';
						}
					}
					else
					{
						echo '<form action="includes/login.inc.php" method="POST">
					<input type="text" name="uid" placeholder="USN or Email">
					<input type="password" name="pwd" placeholder="Password">
					<button type="submit" name="submit">Login</button>
				</form>
				<a href="signup.php">Sign up</a>';
					}
				 ?>
			</div>
		</div>
	</nav>
</header>