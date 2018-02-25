<?php 

include 'utilities.php';

$people = json_decode(file_get_contents("people.json"), true);

$connection = new mysqli('localhost', 'root', '', 'phone_store');

$get_clients = $connection->query("SELECT name, password FROM clients");

$clients = [];

$clients =get_info($clients,$get_clients);

//check method
switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':

	    die('not today');
        
		break;
	case 'POST':
            //verified user name and password
	    	$name = filter_var($_POST['username'],FILTER_SANITIZE_STRING);

	        $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);


	        for ($i=0; $i < count($clients) ; $i++) { 

	        // check if user name exist
	        
	        if ($name === $clients[$i]['name']) {

	        	$index = array_search($name, array_column($clients, 'name'));


	        	// check user password

	        	if ($password = $clients[$index]['password']) {

	        		// if both user name andd password true , set cookie

                    setcookie('username' , $_POST['username'] , time()+2400);

                    file_put_contents('users_text/' . $name . '.txt' , json_encode(['username' => $name , 'password' => $password]));

                    header('Location: index.php');

	    	        die();

	             }else{


      		        header('Location: index.php?error= Wrong password');


		            die();

	            }
	        	
	        }else{

	            	header('Location: index.php?error= Wrong user name ');


	        	}
	        }


	        break;

	    }





 ?>