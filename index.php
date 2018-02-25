<?php 
include 'utilities.php';

include 'index.html';

// check the connection 
$connection = new mysqli('localhost', 'root', '', 'phone_store');

if ($connection ->connect_error) {
	echo $connection ->connect_error;die();
}

//find products from mysqli
$products = $connection->query("SELECT id, name, image, company, color, price FROM phones");

$phones = [];

$phones = get_info($phones,$products);

//check cookie
if (isset($_COOKIE['username'])) {

    $result = check_cookie($_COOKIE['username']);
}

 ?>

 <style type="text/css">
 	    #profilePicDiv{
        width: 40px;
        height: 40px;
        background-image: url(profile_images/<?php echo $_COOKIE['username']; ?>.png);
        background-repeat: no-repeat;
        background-size: cover;
        border-radius: 50%;
        border:1px solid black;
        margin-right: .5rem;


    }
 </style>

<header>
	<div id="storeHeader">
	     <h1><img src="super_phone_logo.png"></h1>
	     <img id="headerImage" src="https://www.allviewmobile.com/x2/assets/images/tel3.png">
	     <div id="insideStoreHeader">
	     <h3>Find your next phone</h3>
	     </div>
	</div>

	<form action="search.php" method="POST">
		<label>
			<span>Select color</span>
			<select name="selectColor">
				<option>All</option>
				<option>Black</option>
				<option>White</option>
				<option>Grey</option>
			</select>
		</label>
		<label>
			<span>Select brand</span>
			<select name="selectComp">
			<option>All</option>
			<option>Apple</option>
			<option>Samsung</option>
			<option>LG</option>
		    <option>Huawei</option>
		    </select>
		</label>
		<label>
			<input type="submit" name="">
		</label>
	</form>
</header>
<main>
	<div id="mainTable">		
	     <?php echo bulid_structure($phones) ?>
	</div>
</main>
<script type="text/javascript">
	
var cookie = <?php echo '"' . $result . '"' ?>;

//check if loged in
if (cookie === "true") {

	var logInForm = document.querySelector('#loginCheck');
	var signUpLink = document.querySelector('#signup');
	logInForm.remove();
	signUpLink.remove();

	//create user nav bar

	var nav = document.querySelector('nav');
	var rightDiv = document.createElement('div');
	var span = document.createElement('span');
	var linkToCart = document.createElement('a');
	var linkToProfile = document.createElement('a');
	var addToCart = document.createElement('button');
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

	//add event to add to cart buttons

	var buttonArray = Array.from(document.querySelectorAll('.addToCartButton'));

	console.log(buttonArray);

	for (var i = 0; i < buttonArray.length; i++) {

		buttonArray[i].addEventListener('click', function (event) {

			var form = event.target;

			var phoneIndex = form.value;

			post('purchases.php' , {new_purchase:phoneIndex});


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