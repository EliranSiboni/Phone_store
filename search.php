<?php 
include 'utilities.php';
include 'index.html';

$connection = new mysqli('localhost', 'root', '', 'phone_store');

//search by select
if (isset($_POST['selectColor']) && isset($_POST['selectComp'])) {
  
      $color = $_POST['selectColor'];
      $company = $_POST['selectComp'];
      $result = [];
     
    if ($color === 'All' && $company !== 'All') {

      $products = $connection->query("SELECT id, name, image, company, color, price FROM phones WHERE company ='$company'");

      $result =get_info($result,$products);

    }elseif ($color !== 'All' && $company === 'All') {

      $products = $connection->query("SELECT id, name, image, company, color, price FROM phones WHERE color='$color'");

      $result =get_info($result,$products);

    }elseif ($color === 'All' && $company === 'All') {

      $products = $connection->query("SELECT id, name, image, company, color, price FROM phones");

      $result =get_info($result,$products);

    }else {
      
    $products = $connection->query("SELECT id, name, image, company, color, price FROM phones WHERE color='$color' and company ='$company'");

      $result =get_info($result,$products);

    }

}
// check if cookie exist - "user loged in"

$username = '';

if (isset($_COOKIE['username'])) {

$username = $_COOKIE['username'];
	
$resultCookie = check_cookie($username);

}


?>

<main>
	<h1>Super Phone</h1>
	<h2>Search result ..</h2>
    <div id="mainTable">
	<table>
		<thead>
			<th>Name</th>
			<th>Image</th>
			<th>Brand</th>
			<th>Color</th>
			<th>Price</th>
		</thead>
		<tbody>
			
	     <?php echo bulid_table($result) ?>

		</tbody>
	</table>

	</div>	
</main>
<script type="text/javascript">
	
var cookie = <?php echo '"' . $resultCookie . '"' ?>;;

if (cookie === "true") {

	var logInForm = document.querySelector('#loginCheck');
	logInForm.remove();

	var nav = document.querySelector('nav');
	var rightDiv = document.createElement('div');
	var span = document.createElement('span');
	var linkToCart = document.createElement('a');
	var linkToProfile = document.createElement('a');
	var logOut = document.createElement('button');

	var profilePicDiv = document.createElement('div');
	var leftNav = document.querySelector('#leftNav');

	span.textContent = "Welcome " + " <?php echo $_COOKIE['username']; ?>" + " , check your purchases";
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
}

function delete_cookie(name) {
	
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';

  location.reload();
}




</script>
</body>
</html>