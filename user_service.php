<?php

// Create the variables that will be used
   $email = $password = ""; // Empty variables as they will be declared/filled in by the user that registers on the website 
   $emailError = $passwordError = ""; // Empty variables as they will be declared later in the function
   $username = $userPassword = $name = "";
   $valid = false;

// check if user exists in users.txt (FOR LOGIN FORM)
function authenticateUser($email, $password) {
    
   // read user input from user.txt when posted to see if account exists. 
   $myfile = fopen("USERS/users.txt", "r");
   fgets($myfile);

   while(!feof($myfile)) { // as long as end of file has not been reached            
               $string = fgets($myfile); // $string reads the user input per line            
               // echo var_dump($string);            
               $parts = explode("|", $string); // $parts breaks string into array with explode function: easy to find specific parts in the file.
        if ($email == $parts[0] && $password == trim($parts[2])) { // The trim() function removes whitespace and other predefined characters from both sides of a string.
        return array ( "email" => $parts[0], "password" => $parts[2], "name" => $parts[1]);
        }
   }   
   fclose($myfile);
   return null;
};

// check if email exists in users.txt (FOR REGISTER FORM)
function doesEmailExist($email) {
    
   // read user input from user.txt when posted to see if account exists. 
   $myfile = fopen("USERS/users.txt", "r");
   fgets($myfile);

   while(!feof($myfile)) { // as long as end of file has not been reached            
               $string = fgets($myfile); // $string reads the user input per line            
               // echo var_dump($string);            
               $parts = explode("|", $string); // $parts breaks string into array with explode function: easy to find specific parts in the file.
               
        if ($email == $parts[0]) {
             fclose($myfile);
             return true;                    
        }
    }    
    fclose($myfile);
    return false;
}; 
    

function storeUser($data) { 
    $myfile = fopen("USERS/users.txt", "a+");
    
    $userData = $data['email'] .'|'. $data['name'] .'|'. $data['password']; // $userData is received from user input and added to USERS/users.txt
    fwrite($myfile,  PHP_EOL . $userData);
    fclose($myfile);
};

?>
