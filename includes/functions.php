<?php
include('connect.php');

if(isset($_POST['login_btn'])) {
	login();
}

function login() {
	global $db, $email;

	$email = mysqli_real_escape_string($db, $_POST['email']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	$password = md5($password);
	

	$query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
	$results = mysqli_query($db, $query);

	if (mysqli_num_rows($results) == 1) { // user found
		unset($_SESSION['status']); // prevent alert from popping
		// check if user is admin or user
		$logged_in_user = mysqli_fetch_assoc($results);
		if ($logged_in_user['user_type'] == 'admin') {
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['success']  = "You are now logged in";
			header('location: home.php');		  
		} else {
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['success']  = "You are now logged in";
			header('location: logged_in/menu.php');
		}
	} else {
		$_SESSION['status']  = "Wrong username or password.";
		header('location: login.php');
	}
	
}

// tells if the user is logged in or not
function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	} else {
		return false;
	}
}


?>