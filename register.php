<?php
function showRegisterContent(){

// Create the variables that will be used
$name = $email = $password = $r_password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
$nameError = $emailError = $passwordError = $r_passwordError = ""; // Empty variables as they will be declared later in the function
$valid = false;

  
// If/else statement checks whether the form has been submitted using $_SERVER["REQUEST_METHOD"]
// If the REQUEST_METHOD is POST, then the form has been submitted.
// If validation is incorrect, an error message will appear. 

// The only attribute that PHP can read via method POST is using the name of the object, NOT the ID
// Therefore $_POST receives the name value of the password input element.

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
	  if (empty($_POST["name"])){  // If "name" is empty (not filled in) show error message "Name required"
		  $nameError="Naam verplicht";
	  } else {
		  $name = test_input($_POST["name"]); // If "name" is filled in, use user input to declare the value for $name in "name" 
	  }; 
	  if (empty($_POST["email"])){
		  $emailError="E-mail verplicht";
	  } else { 
	       $email = test_input($_POST["email"]);
	  };
	  if (empty($_POST["password"])){
		  $passwordError="Wachtwoord verplicht";
	  } else {
		  $password = test_input($_POST["password"]);
	  }; 
	  if (empty($_POST["r_password"]) || ($password != $r_password)){ // checks if password and repeated password are the same
		  $r_passwordError="Wachtwoord niet ingevuld of komt niet overeen";
	  } else {
		  $r_password = test_input($_POST["r_password"]);
	  };
		  
// This if/else statement checks if all the errors are empty and therefore if the form is valid or not.	
   
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($r_passwordError)){
      $valid = true;
	} else {
      $valid = false;
	}
  };


if (!$valid) { // Show the next part only when $valid is false
  echo '
    <!-- The register form is created: -->

    <h2>Maak een account aan</h2>
	<hr>
	
    <form method="POST" action="index.php">
	<p><span class="error">* Verplicht </span></p>
	
	<label for="name">Naam:</label>
	<input type="text" name="name" id="email" value= "' . $name . '">
	<span class="error">* ' . $nameError . ' </span>
	<br>
	
	<label for="email">E-mail:</label>
	<input type="email" name="email" id="email" value= "' . $email . '">
	<span class="error">* ' . $emailError . ' </span>
	<br>
	
	<label for="password">Wachtwoord:</label>
	<input type="password" name="password" id="password" value= "'.$password.'">
	<span class="error">* ' . $passwordError . ' </span>
	<br>
	
	<label for="r_password">Herhaal wachtwoord:</label>
	<input type="password" name="password" id="r_password" value= "'.$r_password.'">
	<span class="error">* ' . $r_passwordError . ' </span>
	<br>
	<br>
	
	<input type="submit" name="submit" value="Verstuur">
	<input type="hidden" id="page" name="page" value="register" > 
	
	</form> ';
	
    } else { // Happens only when $valid = true 
	if (!empty($name) && !empty($email) && !empty($password) && !empty($r_password)){	
      $userfile = fopen("USER\user.txt", "a+");
      echo fread($userfile,filesize("USER\user.txt"));
	  };
};

};

// Create function that does all the checking

function test_input($data){
    $data= trim($data); // strips unnecessary characters
	$data = stripslashes($data); //  removes backslashes from the user input data
  return $data;
  };
  
?>
