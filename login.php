<?php


function validateLogin() {
    
    // Create the variables that will be used
    $email = $password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
    $emailError = $passwordError = ""; // Empty variables as they will be declared later in the function
    $username = $userPassword = $name = "";
    $valid = false;
    
    // Set session variables for login and logout
    $_SESSION["username"] = $email;
    $_SESSION["password"] = $password;
    $_SESSION["name"] = $name;

   if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
    // read user input from user.txt when posted to see if account exists. 
    $myfile = fopen("USERS/users.txt", "r");
    fgets($myfile);

    // testing the input
    $email = testInput(getPostVar("email")); 
    $password = testInput(getPostVar("password"));
    
    if (empty($email)) {
        $emailError="Gebruikersnaam verplicht";
    } 
    if (empty($password)) {
        $passwordError="Wachtwoord verplicht";
        } else {
        while(!feof($myfile)) { // as long as end of file has not been reached            
            $string = fgets($myfile); // $string reads the user input per line            
            // echo var_dump($string);            
            $parts = explode("|", $string); // $parts breaks string into array with explode function: easy to find specific parts in the file.                        
            
            if ($email == $parts[0] && $password == $parts[2]) { 
                $username = $parts[0];
                $userPassword = $parts[2];
                $name = $parts[1];
            }      
        }        
        fclose($myfile);

        if ($username != $email) {                
        $emailError = "Gebruiker niet bekend";            
        } 
        else if ($password != $userPassword) {
        $passwordError = "Wachtwoord niet ingevuld of incorrect";
        }
    
    // This if/else statement checks if all the errors are empty and shows if the form is valid or not.
    if (empty($emailError) && empty($passwordError)){
              $valid = true;
    } else {
              $valid = false;
    }
    // echo $_SESSION["username"] = $email;;
    }
   }
   
    return array("email" => $email, "emailError" => $emailError, "password" => $password, 
                 "passwordError" => $passwordError, "name" => $name, "valid" => $valid);
}

function doLoginUser($data) {
    $myfile = fopen("USERS/users.txt", "r");
    fclose($myfile);
      
};
	
function showLoginForm($data) { 
echo '
<!-- The login form is created: -->

    <h2>Log in met je account</h2>
  <hr>
  
<form method="POST" action="index.php">
<p><span class="error">* Verplicht </span></p>

<label for="email">Gebruikersnaam:</label>
    <input type="text" name="email" value="' . $data['email'] . '" title= "Gebruik je email als gebruikersnaam">
  <span class="error">* ' . $data['emailError'] . ' </span>
  
  <br>
  
    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" value="'. $data['password'] .'">
  <span class="error">* '. $data['passwordError'] .' </span>
  
  <br>
  <br>
  
    <button type="submit">Log in</button>
  <input type="hidden" id="page" name="page" value="login">';
  
  };
  
    
?>