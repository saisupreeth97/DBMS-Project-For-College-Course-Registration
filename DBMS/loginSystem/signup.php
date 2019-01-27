<?php 
	include_once 'header.php';
 ?>
<body class="backimg">
<section class="main-container">
	<div class="main-wrapper">
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="Firstname" required>
			<input type="text" name="last" placeholder="Lastname" required>
			<input type="text" name="email" placeholder="Email" required>
			<input type="text" name="uid" placeholder="USN" required>
			<input type="password" name="pwd" placeholder="Password" required>
			<p style="color: red; font-size: 30px;">Select Department: <select style="height: 30px; width: 70px;border:3px black;" name="dept">
			<option value="NONE">NONE</option>
			<option value="ISE">ISE</option>
			<option value="CSE">CSE</option>
			<option value="ECE">ECE</option>
			<option value="MECH">MECH</option>
			<option value="IT">IT</option>
			<option value="CIVIL">CIVIL</option>
			<option value="BIO">BIO</option>
			</select></p>
			<button type="submit" name="submit">Sign up</button>
		</form>
	</div>
</section>
</body>
<?php 
	include_once 'footer.php';
 ?>