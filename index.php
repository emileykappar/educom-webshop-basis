
<?php

// This is the main application

// variable $page is defined to bring user to the right webpage with GET or POST request

$page = getRequestedPage();
showResponsePage($page);


// functions are defined:

function getRequestedPage() { // Retrieves requested page with POST(getPostVar) or GET(getUrlVar) method 
	$requested_type = $_SERVER["REQUEST_METHOD"];
	if ($requested_type == "POST"){
		$requested_page = getPostVar("page", "home");
	} else { // So if REQUEST_METHOD = "GET"
		$requested_page = getUrlVar("page", "home");
	} return $requested_page;
};

// Show the requested page 

function showResponsePage($page) {
	beginDocument(); // no $page included as it stays the same on every page!
	showHeadSection();
	ShowBodySection($page); // $page included, to show the body section of the right page.
	endDocument();
};

// If variables are set in $array and $key, return these variables otherwise return the default variable $default. 

function getArrayVar($array, $key, $default="") {
	return isset($array[$key]) ? $array[$key] : $default; // If variables are set in $array and $key, return these variables otherwise return the default variable $default. 
};

// 

function getPostVar($key, $default="") {
	return getArrayVar($_POST, $key, $default);
};

// 

function getUrlVar($key, $default="") {
	return getArrayVar($_GET, $key, $default);
};

// This function starts the document:

function beginDocument() {
	echo "<!DOCTYPE html>
	<html>";
};

// This function shows the head section of the document

function showHeadSection() {
	echo '<head> 
    <title> Emiley\'s website </title>
	<link rel="stylesheet" href="CSS\stylesheet.css">
  </head>';
};

// This function shows the body of the webpage

function showBodySection($page) {
	echo '<body> <div id="pageContainer">' . PHP_EOL; // PHP_EOL; The correct 'End Of Line' symbol for this platform. 
	showHeader($page);
    showMenu(); 
    showContent($page); 
    showFooter();
	echo '</div></body>' . PHP_EOL;
};

// This fucntion shows the end of the webpage. 
function endDocument() {
	echo "</html>";
};

// This function shows the header info
// Needs the $page variable included as it is different for each webpage

function showHeader($page) {
	echo " <h1> Welkom op mijn website! </h1>";     
};

// This function shows the navigation menu:
function showMenu() {
   echo '<ul class="navBar">' . PHP_EOL;
   showMenuItem("home", " Home ");
   showMenuItem("about", " About ");
   showMenuItem("contact", " Contact ");
   showMenuItem("register", " Registreren ");
   showMenuItem("login", " Log in ");
   echo '</ul>';
 };
 
// This function shows the menu items
function showMenuItem($link, $label) {
	echo '<li> ';
	echo '<a href="index.php?page=' . $link . '">' . $label . '</a>';
	echo '</li>';
};

// This function shows the content per page. 
function showContent($page){
	switch ($page){
		case "home" :
		  require("home.php");
		  showHomeContent();
		  break;
		case "about" :
		  require("about.php");
		  showAboutContent();
		  break;
		case "contact" :
		  require("contact.php");
		  showContactContent();
		  break;
		  case "register" :
		  require("register.php");
		  showRegisterContent();
		  break;
		case "login" :
		  require("login.php");
		  showLoginContent();
		  break;
		case "other" :
		  require("other.php");
		  showOtherContent();
		  break;
	}
};

// create a function that will do all the checking of the data for us in the forms
function testInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	};

// This function shows the footer
function showFooter(){
	echo "<footer> <!-- Creates the footer -->
     <p> &copy; 2022, Emiley Kappar
	 </p>
   </footer>";
};


?>

