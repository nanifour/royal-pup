<?php  
//Start session
session_start();

// Setup
  $messages = array();
  $error = FALSE;

// Get parameters from form 
  $name = $_POST['name'];
  $nickname = $_POST['nickname'];
  $email = $_POST['email'];
  $userid = $_POST['userid']; 
  $pwdone = $_POST['password_1'];
  $pwdtwo = $_POST['password_2'];
  $zipcode = $_POST['zipcode'];
  $phone = $_POST['phone'];


// Validate the parameters from the form 
if ( empty($name) || ! preg_match('/^[a-zA-Z0-9 ]{2,}$/', $name) )
  {
    $error = TRUE;
    $_SESSION['message'] = "The name field is required, and can contain only letters, numbers, and spaces.";
  }

if ( empty($nickname) || ! preg_match('/^[a-zA-Z0-9]{2,}$/', $nickname) )
  {
    $error = TRUE;
    $_SESSION['message'] = "The nickname field is required, and can contain only letters, numbers, and spaces.";
  }

if ( empty($email) || ! preg_match('/^.+@.+$/', $email) )
  {
    $error = TRUE;
    $_SESSION['message'] = "A valid email address is required.";
  }

if ( empty($userid) || ! preg_match('/^[a-zA-Z0-9 ]{2,}$/', $userid ))
{
  $error = TRUE;
  $_SESSION['message'] = "A user id is required.";

}

if ( empty($zipcode) || strlen($zipcode) != 5 || ! is_numeric($zipcode) )
  {
    $error = TRUE;
    $_SESSION['message'] = "A five digit zip code is required.";
    
  }

if ( empty($phone) || strlen($phone) != 7 || ! is_numeric($phone) )
  {
    $error = TRUE;
    $_SESSION['message'] = "A seven digit phone number is required.";
  }  

//Generate a password hash
$password = $_REQUEST['password_1'];  // registration
$hash = password_hash($password, PASSWORD_DEFAULT);


//Save to database
$db = new SQLite3('user.db');  // open the DB

  $command = "insert into user values('".$name  ."', '"
  .$nickname   ."', '"
  .$email  ."','"
  .$userid  ."',  '"
  .$hash  ."', '"
  .$zipcode  ."', '"
  .$phone."')";    //save inserted values

  $result = $db->exec($command); // execute the command
  if ($result){
    echo "You are successfully signed up";
  }
  else {
    echo "Something went wrong with the sign up";
  }
  $db->close();



// Welcome message in session if the parameters are valid or there are no errors
  if(! $error) {
    $_SESSION['message'] = "Welcome, " . $name . ". " . "You are officially a Royal Pups Member! " . "You are now signed up for our updates, offers, and fan exclusives! ";
  }
 

//check if message is set 
if (isset($_SESSION['message'])){
//redirect with message
  header("location: registration.php");
  exit;
  //echo $_SESSION['message']; 
}

//clear message
//unset($_SESSION['message']);


?>

