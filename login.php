<?php

function showLoginContent() {
  $data = validateLogin();
  if ($data['valid']) {
    showHomeContent();
  } else { 
    showLoginForm($data);
  };

};


function validateLogin() {
  
// Create the variables that will be used
$username = $password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
$usernameError = $passwordError = ""; // Empty variables as they will be declared later in the function
$valid = false;



if ($_SERVER["REQUEST_METHOD"] == "POST"){
  
    $username = testInput(getPostVar("username")); 
    $password = testInput(getPostVar("password"));

    if (empty($username)){
      $usernameError="Gebruikersnaam verplicht";
    } if (empty($password)){
      $passwordError="Wachtwoord verplicht";
    };
    
// This if/else statement checks if all the errors are empty and shows if the form is valid or not.
if (empty($usernameError) && empty($passwordError)){
      $valid = true;
  } else {
      $valid = false;
  };
  };

return array("username" => $username, "usernameError" => $usernameError,
"password" => $password, "passwordError" => $passwordError, "valid" => $valid);
};

function showLoginForm($data) { 
echo '
<!-- The login form is created: -->

    <h2>Log in met je account</h2>
  <hr>
  
<form method="POST" action="index.php">
<p><span class="error">* Verplicht </span></p>

<label for="username">Gebruikersnaam:</label>
    <input type="text" name="username" value="' . $data['username'] . '">
  <span class="error">* ' . $data['usernameError'] . ' </span>
  
  <br>
  
    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" value="'. $data['password'] .'">
  <span class="error">* '. $data['passwordError'] .' </span>
  
  <br>
  <br>
  
    <button type="submit">Log in</button>
  <input type="hidden" value="home" id="page" name="page">';
  
  };
?>