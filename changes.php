<?php 
$connection = new mysqli('localhost', 'root', '', 'phone_store');

switch ($_POST[$str]) {
	case $str === 'new_name':

    $name = $_COOKIE['username'];

    $new_name = $_POST['new_name'];

    $new_client_name = $connection->query("UPDATE clients SET name='$new_name' WHERE name ='$name'");

    rename("profile_images/" . "$name" . ".png", "profile_images/" . "$new_name" . ".png");

    unset($_COOKIE['username']);

    $res = setcookie('username', '', time() - 3600);

    header('Location:index.php');
		break;

	case $str === 'new_phone':
		
		break;

	case $str === 'new_address':
		
		break;

	case $str === 'new_password':
		
		break;
	
	default:
		# code...
		break;
}

