<?php
function showLoginContent(){
	
// Create the variables that will be used
$username = $password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
$usernameError = $passwordError = ""; // Empty variables as they will be declared later in the function
$valid = false;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	  if (empty($_POST["username"])){ 
		  $usernameError="Gebruikersnaam verplicht";
	  } else {
		  $username = test_input($_POST["username"]); 
	  }; 
	  if (empty($_POST["password"])){
		  $passwordError="Wachtwoord verplicht";
	  } else {
		  $password = test_input($_POST["password"]);
	  };
	  
	  if (empty($usernameError) && empty($passwordError)){
      $valid = true;
	} else {
      $valid = false;
	};
};

echo '
<!-- The login form is created: -->

    <h2>Log in met je account</h2>
	<hr>
	
<form method="POST" action="index.php">
<p><span class="error">* Verplicht </span></p>

<label for="username">Gebruikersnaam:</label>
    <input type="text" name="username" value= "' . $username . '">
	<span class="error">* ' . $usernameError . ' </span>
	
	<br>
	
    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" value= "'.$password.'">
	<span class="error">* '.$passwordError.' </span>
	
	<br>
	<br>
	
    <button type="submit">Log in</button>
	<input type="hidden" value="home" id="page" name="page">';
	
	};

// Create function that does all the checking

function test_input($data){
    $data= trim($data); // strips unnecessary characters
	$data = stripslashes($data); //  removes backslashes from the user input data
  return $data;
  };

	
?>