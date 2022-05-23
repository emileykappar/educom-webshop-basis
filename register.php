<?php
session_start();

function showRegisterContent() {
  $data = validateRegister();
  if ($data['valid']) {
    showLoginContent();
  } else {
    showRegisterForm($data);
  };
  
$_SESSION["name"] = $data['name'];
$_SESSION["email"] = $data['email'];
$_SESSION["password"] = $data['password'];
$_SESSION["r_password"] = $data['r_password'];

}; 

function validateRegister() { 

// Create the variables that will be used
$name = $email = $password = $r_password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
$nameError = $emailError = $passwordError = $r_passwordError = ""; // Empty variables as they will be declared later in the function
$valid = false;

$name = testInput(getPostVar("name"));
$email = testInput(getPostVar("email"));
$password = testInput(getPostVar("password"));
$r_password = testInput(getPostVar("r_password"));


// If/else statement checks whether the form has been submitted using $_SERVER["REQUEST_METHOD"]
// If the REQUEST_METHOD is POST, then the form has been submitted.
// If validation is incorrect, an error message will appear. 

  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($name)){  // If "name" is empty (not filled in) show error message "Name required"
      $nameError="Naam verplicht";
    } if (empty($email)){
      $emailError="E-mail verplicht";
    } if (empty($password)){
      $passwordError="Wachtwoord verplicht";
    } if (empty($r_password) || ($password != $r_password)){ // checks if password and repeated password are the same
      $r_passwordError="Wachtwoord niet ingevuld of komt niet overeen";
    };
      
// This if/else statement checks if all the errors are empty and therefore if the form is valid or not.  
    if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($r_passwordError)){
      $valid = true;
  } else {
      $valid = false;
  }
  };
      
return array("name" => $name, "nameError" => $nameError, "email" => $email, "emailError" => $emailError,
"password" => $password, "passwordError" =>$passwordError, "r_password" => $r_password,
"r_passwordError" => $r_passwordError, "valid" => $valid);

// link user.txt to this file
$text= $data['email'] . ' | ' . $data['name'] . ' | ' . $data['password']; // The text that needs to be written to add a new account in users.txt
$myfile = fopen("USERS\user.txt", "a+"); // a+ meand this file can read and/or write in user.txt and preservers the current content by writing to the end of the file
$userdata= fread($myfile, filesize("USER\user.txt"));
fclose ($myfile);


if (file_exists($userdata)) {
  $string = implode($userdata); // $string is the data in the user.txt file , so all data in the user.txt file returns as a string
  $string = explode("|", $string); // the data is being read and seperated by ' | '
  $users = array();
  foreach ($string as $value) { // Each array element is checked and assigned to $value (so: username, password, email addres)
  $user = explode('|', $value);
  };
  
  if (isset($users[$_POST['email']])) {
    echo 'Die gebruiker bestaat al, gebruik een anders email adres';
      }
  };
  
  
    fclose ($userfile);
    $userdata = 'users.txt';
};

function showRegisterForm($data) { // Show the next part only when $valid is false
  echo '
    <!-- The register form is created: -->

    <h2>Maak een account</h2>
  <hr>
  
    <form method="POST" action="index.php">
  <p><span class="error">* Verplicht </span></p>
  
  <label for="name">Naam:</label>
  <input type="text" name="name" id="email" value= "' . $data['name'] . '">
  <span class="error">* ' . $data['nameError'] . ' </span>
  <br>
  
  <label for="email">E-mail:</label>
  <input type="email" name="email" id="email" value= "' . $data['email'] . '">
  <span class="error">* ' . $data['emailError'] . ' </span>
  <br>
  
  <label for="password">Wachtwoord:</label>
  <input type="password" name="password" id="password" value="'.$data['password'].'">
  <span class="error">* ' . $data['passwordError'] . ' </span>
  <br>
  
  <label for="r_password">Herhaal wachtwoord:</label>
  <input type="password" name="password" id="r_password" value="'.$data['r_password'].'">
  <span class="error">* ' . $data['r_passwordError'] . ' </span>
  <br>
  <br>
  
  <input type="submit" name="submit" value="Verstuur">
  <input type="hidden" id="page" name="page" value="register" > 
  
  </form> ';
  
    }; 



?>
