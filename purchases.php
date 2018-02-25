<?php 

include 'utilities.php';

include 'index.html';

// check if cookie exist - "user loged in"

$username = $_COOKIE['username'];

if (!isset($username)) {

	header('Location:index.php');
	
}

$result = check_cookie($username);

$connection = new mysqli('localhost', 'root', '', 'phone_store');

//find client id from client list
$purchases = $connection->query("SELECT 
	                             id
	                             FROM clients WHERE name='$username'");

$find_purchases = [];

$find_purchases = get_info($find_purchases,$purchases);

$user_id = $find_purchases[0]['id'];

// add to cart if exict
if (isset($_POST['new_purchase'])) {

	$new_phone = $_POST['new_purchase'];

	$add_purchase_to_database =  $connection->query("INSERT INTO 
		                                             purchases (user_id,phone_id) 
		                                             VALUES ('$user_id','$new_phone') ");
	
}
//find the client purchases by user_id from purchases list
$find_purchases = $connection->query("
                                 SELECT 
                                 `phone_id` 
                                 FROM `purchases` WHERE `user_id` = '$user_id'
	                             ");

$find_new_purchaes = [];

$find_new_purchaes = get_info($find_new_purchaes , $find_purchases);

//find the phone id from the user purchases list

$last_result=[];

foreach ($find_new_purchaes as $row) {

	$number = $row['phone_id'];

	//find phone details from phones list
	$last_purchases = $connection->query("SELECT p.id, 
		                                         p.name, 
	                                             p.image, 
	                                             p.company, 
	                                             p.color, 
	                                             p.price 
		                                         FROM phones p 
	                                             WHERE p.id='$number'");


	$last_result = get_info($last_result,$last_purchases);
}

//remove from cart
if (isset($_POST['remove_purchase'])) {

	$remove_purchase = $_POST['remove_purchase'];

	$add_purchase_to_database =  $connection->query("DELETE FROM `purchases` WHERE `purchases`.`phone_id` = '$remove_purchase'");
	
}



 ?>

 <main>
 	<h2>Hello <?php echo $username; ?> , your last purchases :</h2>
	<div id="mainTable">
	<table>
		<thead>
			<th>Name</th>
			<th>Image</th>
			<th>Brand</th>
			<th>Color</th>
			<th>Payed</th>
		</thead>
		<tbody>

			<?php echo bulid_table($last_result);

			 ?>
			

		</tbody>
	</table>

	</div>
</main>

<script type="text/javascript">

var cookie = <?php echo '"' . $result . '"' ?>;

if (cookie === "true") {

	var logInForm = document.querySelector('#loginCheck');
	logInForm.remove();

	var signUpLink = document.querySelector('#signup');
	signUpLink.remove();



	var nav = document.querySelector('nav');
	var rightDiv = document.createElement('div');
	var span = document.createElement('span');
	var linkToCart = document.createElement('a');
	var linkToProfile = document.createElement('a');
	var logOut = document.createElement('button');

	var profilePicDiv = document.createElement('div');
	var leftNav = document.querySelector('#leftNav');

	span.textContent =" <?php echo $_COOKIE['username']; ?>";
	linkToCart.textContent = "Cart";
	linkToProfile.textContent = "profile";
	logOut.textContent = "Log Out";

	logOut.setAttribute("id","logOutButton");
	linkToCart.setAttribute("href", "purchases.php?<?php echo $_COOKIE['username'];  ?>");
	linkToProfile.setAttribute("href", "profile.php");
	rightDiv.setAttribute("id","rightDiv");
	profilePicDiv.setAttribute("id", "profilePicDiv");

	nav.appendChild(span);
	nav.appendChild(rightDiv);
	rightDiv.appendChild(linkToCart);
	rightDiv.appendChild(logOut);
	leftNav.appendChild(profilePicDiv);
	leftNav.appendChild(linkToProfile);

	logOut.addEventListener('click', function (event) {

		var form = event.target;

		delete_cookie('username');

	});

	//add event to add to cart buttons

	var buttonArray = Array.from(document.querySelectorAll('.removeFromCart'));

	for (var i = 0; i < buttonArray.length; i++) {

		buttonArray[i].addEventListener('click', function (event) {

			var form = event.target;

			var phoneIndex = form.value;

			console.log(phoneIndex);

			post('purchases.php' , {remove_purchase:phoneIndex});

		});
	}

}

function delete_cookie(name) {

  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';

  location.reload();

}

function post(path, params, method) {
    method = method || "post";

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

</script>