<?php

/* This needs to be here in order for sessions to work */
session_start();

/*requiring the database.php file to be posted here*/
require 'database.php';

/* If the current user logged in */
if( isset($_SESSION['user_id']) ){
	
	/* Verifies that it is the correct user with the current session */
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE id = :id');
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	
	/* If there is not a result in the database, the user is set to null. There is no user authentication */
	$user = NULL;
	
	/* If we did get back a user, set a variable */
	if( count($results) > 0){
		$user = $results;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>PHP Login System</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>

<!-- user id = session id -->

	<div class="header">
		<?php require 'menu.php'; ?>
	</div>
	
    <!-- If the user is logged in he/she will see this -->
	<?php if( !empty($user) ): ?>
		
		<br />Welcome <?= $user['email']; ?> 
		<br /><br />You are now successfully logged in!
		<br /><br />
        <p>Welcome to your own personal page</p>
        <a href="http://swpgraphics.com" target="_blank">Portfolio</a><br><br><br>
		<a href="logout.php">Logout of here?</a>
        
	<!-- If the user is NOT logged in he/she will see this -->
	<?php else: ?>

		<h1>What would you like to do?</h1>
        <!-- Link to the login.php page -->        
		<a href="login.php"><p>Login here</p></a> or
        
        <!-- Link to the register.php page -->
		<a href="register.php"><p>Register for a profile</p></a>
        
        <p class="p">If you log in, you will be redirected to your own personal page!</p>

	<?php endif; ?>
    <?php require 'footer.php'; ?>

</body>
</html>