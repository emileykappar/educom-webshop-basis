<?php


function validateLogin() {
    
    // Create the variables that will be used
    $regEmail = $regPassword = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
    $regEmailError = $regPasswordError = ""; // Empty variables as they will be declared later in the function
    $username = $userPassword = $name = "";
    $valid = false;
    
    // Set session variables for login and logout
    $_SESSION["username"] = $regEmail;
    $_SESSION["password"] = $regPassword;
    $_SESSION["name"] = $name;

   if ($_SERVER["REQUEST_METHOD"] == "POST"){
	
    // read user input from user.txt when posted to see if account exists. 
    $myfile = fopen("USERS/users.txt", "r");
    fgets($myfile);

    // testing the input
    $regEmail = testInput(getPostVar("regEmail")); 
    $regPassword = testInput(getPostVar("regPassword"));
    
    if (empty($regEmail)) {
        $regEmailError="Gebruikersnaam verplicht";
    } 
    if (empty($regPassword)) {
        $regPasswordError="Wachtwoord verplicht";
        } else {
        while(!feof($myfile)) { // as long as end of file has not been reached            
            $string = fgets($myfile); // $string reads the user input per line            
            // echo var_dump($string);            
            $parts = explode("|", $string); // $parts breaks string into array with explode function: easy to find specific parts in the file.                        
            
            if ($regEmail == $parts[0] && $regPassword == $parts[2]) { 
                $username = $parts[0];
                $userPassword = $parts[2];
                $name = $parts[1];
            }      
        }        
        fclose($myfile);

        if ($username != $regEmail) {                
        $regEmailError = "Gebruiker niet bekend";            
        } 
        else if ($regPassword != $userPassword) {
        $regPasswordError = "Wachtwoord niet ingevuld of incorrect";
        }
    
    // This if/else statement checks if all the errors are empty and shows if the form is valid or not.
    if (empty($regEmailError) && empty($regPasswordError)){
              $valid = true;
    } else {
              $valid = false;
    }
    // echo $_SESSION["username"] = $regEmail;;
    }
   }
   
    return array("regEmail" => $regEmail, "regEmailError" => $regEmailError, "regPassword" => $regPassword, 
                 "regPasswordError" => $regPasswordError, "name" => $name, "valid" => $valid);
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

<label for="regEmail">Gebruikersnaam:</label>
    <input type="text" name="regEmail" value="' . $data['regEmail'] . '" title= "Gebruik je email als gebruikersnaam">
  <span class="error">* ' . $data['regEmailError'] . ' </span>
  
  <br>
  
    <label for="regPassword">Wachtwoord:</label>
    <input type="password" name="regPassword" value="'. $data['regPassword'] .'">
  <span class="error">* '. $data['regPasswordError'] .' </span>
  
  <br>
  <br>
  
    <button type="submit">Log in</button>
  <input type="hidden" id="page" name="page" value="login">';
  
  };
  
    
?>