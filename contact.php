<?php

function showContactContent(){		

// Create variables that will be used
$gender = $name = $email = $tel = $commPref = $message ="";
$genderError = $nameError = $emailError = $telError = $commPrefError = $messageError ="";
$valid= false;
	
// When a user submits a form, we 1) strip unnecessary characters with trim() function
// and 2) remove backslashes from the user input data with striplashes() function
// 3) create a function that will do all the checking for us named test_input() function

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
    return $data;
	};
	

// This code checks whether the form has been submitted using the $_SERVER["REQUEST_METHOD"].
// If the REQUEST_METHOD is POST, then the form has been submitted.

// The if else statements are linked to each $_POST variable. 
// checks if the $_POST variable is empty (with the PHP empty() function) if so, a requirements message is printed.

	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	  if (empty($_POST["gender"])){
	      $genderError ="Keuze verplicht";
	  } else { 
	      $gender = test_input($_POST["gender"]);
	  }
	  if (empty($_POST["name"])){
		  $nameError ="Naam is verplicht";
	  } else {
		  $name = test_input($_POST["name"]);
	  }
	  if (empty($_POST["email"])){
		  $emailError ="E-mail is verplicht";
	  } else {
		  $email = test_input($_POST["email"]);
	  }
	  if (empty($_POST["tel"])){
		  $telError ="Telefoonnummer is verplicht";
	  } else {
		  $tel = test_input($_POST["tel"]);
	  }
	  if (empty($_POST["communicatievoorkeur"])){
		  $commPrefError ="Communicatievoorkeur is verplicht";
	  } else {
		  $commPref = test_input($_POST["communicatievoorkeur"]);
	  }
	  if (empty($_POST["message"])){
		  $messageError ="Je bent je vraag vergeten te stellen!";
	  } else {
		  $message = test_input($_POST["message"]);	  
	  } 
	  
// This if/else statement checks if all the errors are empty and shows if the form is valid or not.
	  
	  if (empty($genderError) && empty($nameError) && empty($emailError) && empty($telError)
		  && empty($commPrefError) && empty($messageError)){
	      $valid = true;
	  } else {
	      $valid = false;
	  }
	};
  	
if (!$valid) { // Show the next part only when $valid is false
	echo '
	<!-- Makes sure that the entered data is displayed on the same page (using the action="filename" of the page it needs to be shown on. -->
    
	<form method="POST" action="index.php">
	<p><span class="error">* Verplicht </span></p>
<!-- Input fields to type in name/email/phone number -->
        <label class="contact" for="gender">Kies je aanhef:</label>
          <select name="gender" id="gender" value="'. $gender .'"> <!-- Creates a dropdown menu with different options -->
		    <option value="">Maak een keuze</option>
			<option value="Dhr.">Dhr.</option>
            <option value="Mvr.">Mvr.</option>
            <option value="Anders.">Anders.</option>
          </select>
		  <span class="error">* '.$genderError.' </span>
          <br>
        <label class= "contact" for="name">Naam:</label>
        <input class= "inputfield" type="text" id="name" name="name" value="' . $name . '" > <!-- PHP code that ensures to show the values in the input fields after the user hits the submit button-->

<!-- In the HTML form, we add a little PHP script after each required field, which generates the correct error message 
if needed (that is if the user tries to submit the form without filling out the required fields)-->

           <span class="error">* '.$nameError.'</span> 
           <br>
		   
        <label class= "contact" for="email">E-mail:</label>
          <input class= "inputfield" type="email" id="email" name="email" value="'.$email.'">
            <span class="error">* '.$emailError.'</span>
            <br>
			
        <label class= "contact" for="tel">Telefoon:</label>
          <input class= "inputfield" type="text" id="tel" name="tel" value="' . $tel . '">
            <span class="error">* ' . $telError . ' </span>
			
			<br>';
  
			
	echo '<p><label>Communicatievoorkeur:</label></p> <!-- Option for communication preference: email or phone -->
	 
       <input type="radio" name="communicatievoorkeur" 
	   if (isset($commPref) && $commPref=="email") '; echo ' "checked" value="email"> 
	   <label>Email</label> ';
		
    echo ' <input type="radio" name="communicatievoorkeur" 
	   if (isset($commPref) && $commPref=="telefoon") '; echo  ' "checked" value="telefoon">
         <label>Telefoon</label> 

         <span class="error">* ' . $commPrefError . ' </span>
         
		 <br>
		 <br> ';

		 
      echo '  <label class="message" for="message" id="message">
	  <p>Wat is je vraag?</p></label> <!-- Creates input for the question-->
	  <textarea class= "inputfield" name="message" rows="5" cols="30">'.$message.'</textarea>
       <span class="error">* '.$messageError.' </span>
      
	  <br>
      <br>
	  
	  <input type="submit" name="submit" value="Verstuur">
	  <input type="hidden" value="contact" id="page" name="page">
	  
 
      </form> '; 
	  
    } else {  // Show the next part only when $valid is true 
     echo '	<!-- Piece of code that ensures the entered data is shown, it echos back the entered data of the form in a new webpage -->
	<h2>Het formulier is verzonden! </h2>
	<span>Aanhef: '. $gender .' </span><br>
    <span>Naam: '. $name .' </span><br>
    <span>Email: '. $email.' </span><br>
	<span>Telefoonnummer: '. $tel .'</span><br>
	<span>Cummunicatievoorkeur: '. $commPref .' </span><br>
    <span>Je bericht: '. $message .' </span> ';
     }; // End of conditional showing 
};  
 
?>