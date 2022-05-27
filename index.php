
<?php

//////////////////// This is the main application //////////////////////

// start session
session_start();

// variable $page is defined to bring user to the right webpage with GET or POST request
$page = getRequestedPage();
$data = processRequest($page);
showResponsePage($data, $page);


// functions are defined:

function getRequestedPage() { // Retrieves requested page with POST(getPostVar) or GET(getUrlVar) method 
	$requested_type = $_SERVER["REQUEST_METHOD"];
		if ($requested_type == "POST"){
			$requested_page = getPostVar("page", "home");
		} else { // So if REQUEST_METHOD = "GET"
			$requested_page = getUrlVar("page", "home");
		} return $requested_page;
};

function processRequest($page) {
	switch($page) {
		case "contact":
            require_once("contact.php");
            $data = validateContact();
            if ($data['valid']) {
                $page = "thanks";
            }
            break;
            
        case "register":
            require_once("register.php");
            $data = validateRegister();
            if ($data['valid']) {
                addUser($data);
                $page = "login";
            }
            break;
		
		case "login":
			require_once("login.php");
			$data = validateLogin();
			if ($data['valid']) {
				doLoginUser($data['regEmail']);
				$page = "home";
            } 
			break;
        
            
				
    }
    $data['page'] = $page;
    return $data;
}
// Show the requested page 

function showResponsePage($data, $page) {
	beginDocument(); // no $page included as it stays the same on every page!
	showHeadSection();
	ShowBodySection($data, $page); // $page included, to show the body section of the right page.
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

function showBodySection($data, $page) {
	echo '<body> <div id="pageContainer">' . PHP_EOL; // PHP_EOL; The correct 'End Of Line' symbol for this platform. 
	showHeader($data['page']);
    if ($page == "login" && $data['valid'])  {
        ShowLogoutMenu($data, $page);
    } else {
        showMenu();
    } 
    showContent($data); 
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
	echo " <h1> Welkom op mijn website! - ".$page. " </h1>";     
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

// the navigation menu when a user is logged in
function ShowLogoutMenu($data, $page) {
    echo '<ul class="navBar">' . PHP_EOL;
	showMenuItem("home", " Home ");
	showMenuItem("about", " About ");
	showMenuItem("contact", " Contact ");
	showMenuItem("home", " Log uit ");
	echo '</ul>';
};
 
// This function shows the menu items
function showMenuItem($link, $label) {
	echo '<li> ';
	echo '<a href="index.php?page=' . $link . '">' . $label . '</a>';
	echo '</li>';
};

// This function shows the content per page. 
function showContent($data){
	switch ($data['page']){
		case "home" :
			require_once("home.php");
			showHomeContent();
			break;
		
		case "about" :
			require_once("about.php");
			showAboutContent();
			break;
			
		case "contact" :
			require_once("contact.php");
			showContactForm($data);
			break;
			
		case "thanks":
			require_once("contact.php");
			showContactThanks($data);
			break;
			
		case "register" :
			require_once("register.php");
			showRegisterForm($data);
			break;
			
		case "login" :
			require_once("login.php");
			showLoginForm($data);
			break;
			
		case "other" :
			require_once("other.php");
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
          <p> &copy; 2022, Emiley Kappar </p>
	      </footer>";
};


?>

