<?php/*
   Subject Code: INT322B
   Student Name: Gerald Encabo
   Date Submitted:
   Student Declaration
   I/we declare that the attached assignment is my/our own work in accordance with Seneca Academic Policy. No part of this assignment has been copied manually or electronically from any other source (including web sites) or distributed to other students.
   Name: Gerald Encabo
   Student #: ID 021-099-114
*/?>
<?php
  session_start();

  if(!isset($_GET['username']))    /* it will destroy cookie once it been log out */
  {
     setcookie("PHPSESSID","",time()-6000, "/");
     session_unset();
     session_destroy();
     header("Location: login.php");
  } 
  else{                           /* it will set the cookie soon the username and password is match */
         setcookie("PHPSESSID","",time()+60*60, "/");
         header("Location: login.php");
      }
?>
