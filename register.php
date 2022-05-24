<?php
 
function validateRegister() { 

    // Create the variables that will be used
    $name = $email = $password = $r_password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
    $nameError = $emailError = $passwordError = $r_passwordError = ""; // Empty variables as they will be declared later in the function
    $valid = false;

    // If/else statement checks whether the form has been submitted using $_SERVER["REQUEST_METHOD"]
    // If the REQUEST_METHOD is POST, then the form has been submitted.
    // If validation is incorrect, an error message will appear. 

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        // Add user input  to the user.txt file if request method == post
        $myfile = fopen("USERS/users.txt", "a+"); // opens the file to read or write data, read if user already exists and if not write the new useraccount data in the file.
    
        // Testing of input
        $name =   testInput(getPostVar("name"));
        $email = testInput(getPostVar("email"));
        $password = testInput(getPostVar("password"));
        $r_password = testInput(getPostVar("r_password"));
  
        if (empty($name)){  // If "name" is empty (not filled in) show error message "Name required"
            $nameError="Naam verplicht";
        } 
        if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
            $emailError="E-mail niet ingevuld of format klopt niet";
        } else {
            while(!feof($myfile)) { // as long as end of file has not been reached, 
                $string = fgets($myfile); // $string reads the user input per line
                $parts = explode("|", $string); // $parts breaks string into array with explode function: easy to find specific parts in the file.
                
                if ($email == $parts[0]) {
                    $emailError = "Email al in gebruik";
                }        
            } 
            fclose($myfile);
        }
        if (empty($password)){
            $passwordError="Wachtwoord verplicht";
        } 
        if (empty($r_password)){
            $r_passwordError="Wachtwoord niet ingevuld";
        } 
        if ($r_password != $password) { // checks if password and repeated password are the same
            $r_passwordError="Wachtwoord komt niet overeen"; 
        } 
        
          
      // This if/else statement checks if all the errors are empty and therefore if the form is valid or not.  
        if (empty($nameError) && empty($emailError) && empty($passwordError) && empty($r_passwordError)){
            $valid = true;
        } else {
            $valid = false;
        }
    }

    return array("name" => $name, "nameError" => $nameError, "email" => $email, "emailError" => $emailError,
                 "password" => $password, "passwordError" =>$passwordError, "r_password" => $r_password,
                 "r_passwordError" => $r_passwordError, "valid" => $valid);
  
}
      
function addUser($data) {
    $myfile = fopen("USERS/users.txt", "a+");
    
    $userData = $data['email'] .'|'. $data['name'] .'|'. $data['password']; // $userData is received from user input and added to USERS/users.txt
    fwrite($myfile, $userData . PHP_EOL);
    fclose($myfile);
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
  <input type="password" name="password" id="password" 
  value="'.$data['password'].'">
  <span class="error">* ' . $data['passwordError'] . ' </span>
  <br>
  
  <label for="r_password">Herhaal wachtwoord:</label>
  <input type="password" name="r_password" id="r_password"
  value="'.$data['r_password'].'">
  <span class="error">* ' . $data['r_passwordError'] . ' </span>
  <br>
  <br>
  
  <input type="submit" name="submit" value="Verstuur">
  <input type="hidden" id="page" name="page" value="register" >
  
  </form> ';
  
  // when user is registrated; go to login page
};
  


?>
