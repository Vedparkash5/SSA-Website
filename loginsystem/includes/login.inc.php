<?php
// make sure user got to this page by clicking login button.
if (isset($_POST['login-submit'])) {

  
  require 'dbh.inc.php';

  // grab all the data which we passed from the signup form so it can be used later 
    
  $mailuid = $_POST['mailuid'];
  $password = $_POST['pwd'];

  //  If error stop the rest of the script from running and take the user back to the login form with an error message.

  // check for any empty inputs. 
    
  if (empty($mailuid) || empty($password)) {
    header("Location: ../index.php?error=emptyfields&mailuid=".$mailuid);
    exit();
  }
  else {

    

    //  get the password from the user in the database that has the same username as what the user typed it.  check if it matches the password the user typed into the login form.

    //  connect to the database using prepared statements which work by us sending SQL to the database first
      
    $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
    // Here we initialize a new statement using the connection from the dbh.inc.php file.
   
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      // If  error we send the user back to the signup page.
      header("Location: ../index.php?error=sqlerror");
      exit();
    }
    else {

      // If there is no error then we continue the script

      //  bind the type of parameters we expect to pass into the statement, and bind the data from the user.
      
     mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      //  execute the prepared statement and send it to the database
      mysqli_stmt_execute($stmt);
      //  result is from the statement.
      $result = mysqli_stmt_get_result($stmt);
      //  store the result into a variable.
      if ($row = mysqli_fetch_assoc($result)) {
        // match the password from the database with user's password
        $pwdCheck = password_verify($password, $row['pwdUsers']);
        // If wrong passord then error message
        if ($pwdCheck == false) {
          // If t error we send the user back to the signup page.
          header("Location: ../index.php?error=wrongpwd");
          exit();
        }
        
        else if ($pwdCheck == true) {

          //  create session variables based on the users information from the database. 
          // with database data store them in session variables which are a type of variables that we can use on all pages that has a session running in it.
          //  start a session HERE to be able to create the variables
          session_start();
          //  create the session variables.
          $_SESSION['id'] = $row['idUsers'];
          $_SESSION['uid'] = $row['uidUsers'];
          $_SESSION['email'] = $row['emailUsers'];
          // Now the user is registered as logged in and we can now take them back to the front page! :)
          header("Location: ../index.php?login=success");
          exit();
        }
      }
      else {
        header("Location: ../index.php?login=wronguidpwd");
        exit();
      }
    }
  }
  //  close the prepared statement and the database connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // If the user tries to access this page without signup (like they use the search bar or something, we send them back to the signup page.
  header("Location: ../signup.php");
  exit();
}
