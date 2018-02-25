<?php 

include 'utilities.php';

include 'index.html';


if (!isset($_COOKIE['username'])) {

	header('Location:index.php');

}

$connection = new mysqli('localhost', 'root', '', 'phone_store');

$get_clients = $connection->query("SELECT name,address,phone,password FROM clients");

$clients = [];

$clients =get_info($clients,$get_clients);

$result = check_cookie($_COOKIE['username']);

$name = $_COOKIE['username'];

for ($i=0; $i < count($clients) ; $i++) { 

	$index = array_search($name, array_column($clients, 'name'));

	$user_phone = $clients[$index]['phone'];
	$user_address = $clients[$index]['address'];
	$user_password = $clients[$index]['password'];
	

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
    #profilePic {
        -webkit-clip-path: circle(50% at 50% 50%);
        clip-path: circle(50% at 50% 50%);
        width: 25rem;
        height: 25rem;
        background-image: url(profile_images/<?php echo $_COOKIE['username']; ?>.png);
        background-size: cover;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
    }

</style>
<main>
	<div id="userInfo">
		<div id="left">
	        <div id="profilePic">
	        	<form action="upload.php" method="post" enctype="multipart/form-data">
                     <span>Select image to upload:</span>
                     <label>
                         <input type="file" name="fileToUpload" id="fileToUpload">
                     </label>
                     <label>
                         <input type="submit" value="Upload Image" name="submit">
                     </label>
                </form>
	        </div>
		</div>
		<div id="right">
			<div id="profileHeader">
			<h1><?php echo $_COOKIE['username']; ?></h1>
			<button class="privacyButtonName">🗝 Change user name</button>
			</div>
			<h2>Phone number : <?php echo $user_phone; ?></h2>
			<h2>Address : <?php echo $user_address ?></h2>
			<h2>Password : <?php echo $user_password; ?></h2>
		</div>
	    <div id="privacy">
	    </div>
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

    document.querySelector('.privacyButtonName').addEventListener('click', function (event) {

	var parentDiv = document.querySelector('#profileHeader');
	var newDiv = document.createElement('div');
	newDiv.setAttribute('id', 'privacyFormDiv');

	var createInput = document.createElement('input');
	var createInputSubmit = document.createElement('input');

	var createLabel = document.createElement('label');
	var createForm = document.createElement('form');

    createInput.setAttribute('name', 'changeUserName');

    createInputSubmit.setAttribute('type', 'submit');
    createInputSubmit.setAttribute('value', 'Change');
    createInputSubmit.setAttribute('class', 'privacyButtonName');


	parentDiv.appendChild(newDiv);
	newDiv.appendChild(createForm);
	createForm.appendChild(createLabel);
	createLabel.appendChild(createInput);
	createLabel.appendChild(createInputSubmit);

    createForm.addEventListener('submit', function (event) {

    	event.preventDefault();

        var form = event.target;

        var newName = form.querySelector('[name="changeUserName"]').value.trim();

        post('changes.php' , {new_name: newName});

    });





});

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