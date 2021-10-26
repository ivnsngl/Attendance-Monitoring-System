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
		header('location: index.php');
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


// Generate employee id
function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Register User
if (isset($_POST['register_btn'])) {
    // receive all input values from the form
	$employee_id = generateRandomString(8);
    $fullname = mysqli_real_escape_string($db, $_POST['fullname']);
    $user_type = "admin";
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
	$password = md5($password);

	$query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
	$results = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($results);

	if ($user) {	
		if ($user['email'] === $email) {
			$_SESSION['status'] = "Email already exists.";
		} else if ($user['email'] === '') {
			$_SESSION['status'] = "Please input all needed data.";
		}
	} else {
		unset($_SESSION['status']);
		date_default_timezone_set("Asia/Manila");
		$date = date('Y-m-d');

		$query = "INSERT INTO `users` (`employee_id`, `fullname`, `user_type`, `email`, `password`, `created_on`)
		VALUES('$employee_id', '$fullname', '$user_type', '$email', '$password', '$date')";
		
		mysqli_query($db, $query) or die(mysqli_error($db));

		$_SESSION['success'] = "Account created successfully.";
		header('location: register.php');
		
	}
    
}
?>