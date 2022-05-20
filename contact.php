<?php
function showContactContent() {
  $data = validateContact();
  if ($data['valid']) {
    showContactThanks($data);
  } else {
    showContactForm($data);
  }
};

function validateContact() {		

// Create variables that will be used
$gender = $name = $email = $tel = $commPref = $message ="";
$genderError = $nameError = $emailError = $telError = $commPrefError = $messageError ="";
$valid= false;
	
// This code checks whether the form has been submitted using the $_SERVER["REQUEST_METHOD"].
// If the REQUEST_METHOD is POST, then the form has been submitted.

// The if else statements are linked to each $_POST variable. 
// checks if the $_POST variable is empty (with the PHP empty() function) if so, a requirements message is printed.

	if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	  if (empty($gender)){
	      $genderError ="Keuze verplicht";
	  } else { 
	      $gender = testInput(getPostVar["gender"]);
	  }
	  if (empty($name)){
		  $nameError ="Naam is verplicht";
	  } else {
		  $name = testInput(getPostVar["name"]);
	  }
	  if (empty($email)){
		  $emailError ="E-mail is verplicht";
	  } else {
		  $email = testInput(getPostVar["email"]);
	  }
	  if (empty($tel)){
		  $telError ="Telefoonnummer is verplicht";
	  } else {
		  $tel = testInput(getPostVar["tel"]);
	  }
	  if (empty($communicatievoorkeur)){
		  $commPrefError ="Communicatievoorkeur is verplicht";
	  } else {
		  $commPref = testInput(getPostVar["communicatievoorkeur"]);
	  }
	  if (empty($message)){
		  $messageError ="Je bent je vraag vergeten te stellen!";
	  } else {
		  $message = testInput(getPostVar["message"]);	  
	  } 
	  
// This if/else statement checks if all the errors are empty and shows if the form is valid or not.
	  
	  if (empty($genderError) && empty($nameError) && empty($emailError) && empty($telError)
		  && empty($commPrefError) && empty($messageError)){
	      $valid = true;
	  } else {
	      $valid = false;
	  }
	};
	
return array("gender" => $gender, "genderError" => $genderError, "name" => $name, "nameError" => $nameError,
"email" => $email, "emailError" => $emailError, "tel" => $tel, "telError" => $telError,"commPref" => $commPref, 
"commPrefError" => $commPrefError, "message" => $message, "messageError" => $messageError, "valid" => $valid);

}; 


function showContactForm($data) { // Shows the next part only when $valid is false
	echo '
	<h2>Contact formulier</h2>
	      <hr>
	<!-- Makes sure that the entered data is displayed on the same page (using the action="filename" of the page it needs to be shown on. -->
    
	<form method="POST" action="index.php">
	<p><span class="error">* Verplicht </span></p>
<!-- Input fields to type in name/email/phone number -->
        <label class="contact" for="gender">Kies je aanhef:</label>
          <select name="gender" id="gender" value="'. $data['gender'] . '">
		    <option value="">Maak een keuze</option>
			<option value="Dhr" '. ($data['gender'] =="Dhr" ? "selected" : "") . ' >Dhr.</option>
            <option value="Mvr" '. ($data['gender'] =="Mvr" ? "selected" : "") . '>Mvr.</option>
            <option value="Anders" '. ($data['gender'] =="Anders" ? "selected" : "") . '>Anders.</option>
          </select>
		  <span class="error">* '. $data['genderError'].' </span>
          <br>
	  
        <label class= "contact" for="name">Naam:</label>
        <input class= "inputfield" type="text" id="name" name="name" value="' . $data['name'] . '"  > <!-- PHP code that ensures to show the values in the input fields after the user hits the submit button-->

<!-- In the HTML form, we add a little PHP script after each required field, which generates the correct error message 
if needed (that is if the user tries to submit the form without filling out the required fields)-->

           <span class="error">* '.$data['nameError'].'</span> 
           <br>
		   
        <label class= "contact" for="email">E-mail:</label>
          <input class= "inputfield" type="email" id="email" name="email" value="'.$data['email'].'" >
            <span class="error">* '.$data['emailError'].'</span>
            <br>
			
        <label class= "contact" for="tel">Telefoon:</label>
          <input class= "inputfield" type="text" id="tel" name="tel" value="' . $data['tel']. '">
            <span class="error">* ' . $data['telError'] . ' </span>
			
			<br>';
  
			
	echo '<p><label>Communicatievoorkeur:</label></p> <!-- Option for communication preference: email or phone -->
	 
       <input type="radio" name="communicatievoorkeur" ' .
	   ($data['commPref'] == "email" ? "checked" : "" ) . ' value="email"> 
	   <label>Email</label> 
	   
	   <input type="radio" name="communicatievoorkeur" ' . 
	($data['commPref'] == "tel" ? "checked" : "" ) . ' value="tel">
         <label>Telefoon</label> 

         <span class="error">* ' . $data['commPrefError'] . ' </span>
         
		 <br>
		 <br> ';

		 
      echo '  <label class="message" for="message" id="message">
	  <p>Wat is je vraag?</p></label> <!-- Creates input for the question-->
	  <textarea class= "inputfield" name="message" rows="5" cols="30">'.$data['message'].'</textarea>
       <span class="error">* '.$data['messageError'].' </span>
      
	  <br>
      <br>
	  
	  <input type="submit" name="submit" value="Verstuur">
	  <input type="hidden"  id="page" name="page" value="contact">
	  
 
      </form> '; 
	  
    };

function showContactThanks($data){  // Show the next part only when $valid is true 
     echo '	<!-- Piece of code that ensures the entered data is shown, it echos back the entered data of the form in a new webpage -->
	<h2>Het formulier is verzonden! </h2>
	<span>Aanhef: '. $data['gender'] .' </span><br>
    <span>Naam: '. $data['name'] .' </span><br>
    <span>Email: '. $data['email'].' </span><br>
	<span>Telefoonnummer: '. $data['tel'] .'</span><br>
	<span>Cummunicatievoorkeur: '. $data['commPref'] .' </span><br>
    <span>Je bericht: '. $data['message'] .' </span> ';
     }; // End of conditional showing   

// create a function that will do all the checking for us named test_input() function
function testInput($data) {
	$data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
return $data;
};

	
 
?>