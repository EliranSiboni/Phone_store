<?php 
include 'index.html';

if (isset($_POST['new_username']) && 
	isset($_POST['new_password']) && 
    isset($_POST['new_address']) && 
    isset($_POST['new_phone'])) 
    
{

	$new_name = filter_var($_POST['new_username'],FILTER_SANITIZE_STRING);
	$new_password = filter_var($_POST['new_password'],FILTER_SANITIZE_STRING);
	$new_address = filter_var($_POST['new_address'],FILTER_SANITIZE_STRING);
	$new_phone = filter_var($_POST['new_phone'],FILTER_SANITIZE_STRING);

    include 'class/client.php';
    
    try {
         
        $client = new Client ($new_password,$new_name,$new_phone,$new_address);
         
        $client->saveToDatabase();
    	
    } catch (Exception $e) {

    	file_put_contents('error.log', $e->getMessage() . ', ' . date('Y-m-d h:i:s') . "\n");

    	echo "Enter valid phone or password";
    	
    }

}
 ?>

<main>
	<header>
	     <h1><img src="super_phone_logo.png"></h1>
	     <span id="spanSignUp">Sign up</span>
	</header>
	
	<form id="signUpForm" method="POST" action="signup.php">
		<span>Please enter:</span>
		<label>
			<span>user name</span>
			<input type="text" name="new_username">
		</label>		
		<label>
			<span>Password</span>
			<input type="password" name="new_password">
		</label>
		<label>
			<span>Address</span>
			<input type="text" name="new_address">
		</label>		
		<label>
			<span>Phone number</span>
			<input type="number" name="new_phone">
		</label>
		<label>
			<input type="submit" value="Join us!">
		</label>
	</form>
</main>
