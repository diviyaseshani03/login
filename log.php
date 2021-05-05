<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'assesment';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if ( !isset($_POST['email'], $_POST['password']) ) {
	// Could not get the data that should have been sent.
	exit('Please fill both the username and password fields!');
}


// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $con->prepare('SELECT emailid, password FROM login WHERE emailid = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
	$stmt->bind_param('s', $_POST['email']);
	$stmt->execute();
	// Store the result so we can check if the account exists in the database.
	$stmt->store_result();

if ($stmt->num_rows > 0) {
	$stmt->bind_result($id, $password);
	$stmt->fetch();
	// Account exists, now we verify the password.
	// Note: remember to use password_hash in your registration file to store the hashed passwords.
	if ($_POST['password'] === $password) {
		// Verification success! User has loggedin!
		// Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.


		session_regenerate_id();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $_POST['email'];
		$_SESSION['id'] = $id;

		echo '<body style="background: linear-gradient(30deg,blue,white);">'.'<p style="margin-left:20%;margin-top:10%; font-size:500%;">' . 'Welcome ' . $_SESSION['name'] . '!' . '<br>'.'Congrats! You have successfully logged in.'.
		'<br><br>

		      <a href="login_form.html" class="btn btn-primary" style="margin-left:30% ;padding:10px 10px; margin-top: 0%; border-radius: 10px;
		      background: linear-gradient(30deg,blue,white); font-weight: bold; font-size: 30px;">Logout</a>' ;
	}
	else {

				 echo '<body style="background: linear-gradient(30deg,blue,white);">'.'<p style="margin-left:30%;margin-top:10%; font-size:500%;">' .'Incorrect Credentials!'.
				 '<br><br>

							 <a href="login_form.html" class="btn btn-primary" style="margin-left:20% ;padding:10px 10px; margin-top: 0%; border-radius: 10px;
							 background: linear-gradient(30deg,blue,white); font-weight: bold; font-size: 30px;">Try again</a>' ;
			 } ;


	$stmt->close();
}
}
?>
