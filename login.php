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
   include 'library.php';

   if(!$_GET)
   {                      /* seperated forms of username, password, submit button and forgot link */
        $username = "Username:<form method=\"post\" action=\"\">
                    <input type=\"text\" name=\"user\" value=\"$_POST[user]\" />";
        $password = "Password:&nbsp; <input type=\"password\" name=\"pass\" value=\"$_POST[pass]\" />";
        $submit = "<input type=\"submit\" value=\"submit\"/>";
        $forgot = "&nbsp;&nbsp;&nbsp;<a href=\"login.php?forgot=yes\" >Forgot password?</a><br/>
                   </form>";
   }

   if($_POST)
   {
      $valid = false;
      $user = mysql_real_escape_string(trim($_POST['user']));  /* getting data username from form */
      $role = "user";

      $connect = new data;

      $sql_query = "SELECT username, password FROM int322.users WHERE username = '$user' AND role = '$role'";
      $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());
 
      while($row = mysqli_fetch_assoc($run))
       {
         if($_POST['user'] == $row['username']);      /* if login username and database username is match the password in database will set to $passwordDB */
            {
              $passwordDB = $row['password'];
              $valid = true;
            }
       }

       $passDBsalt = substr($passwordDB, 0,12);       /* then it will salt it to get 12 character only and crypt the password to improve security */
       $loginpass = crypt($_POST['pass'], $passDBsalt);
       $loginpass = mysql_real_escape_string(trim($loginpass));

       if($loginpass == $passwordDB)   /* once the login password is match to database password the $valid will be true */
       {
           $valid = true;
       }else{
              $valid = false;  
            }
       if($valid)
       {                       /* if the valid is true it will set username and role to session */
          session_start();
          $_SESSION['username'] = trim($user);
          $_SESSION['role'] = trim($role);
          header('Location: view.php');
       }else{                         /* error message if login password and database password is not match */
            $loginError = "Login Failed! try again";
            }         
   }

   if(isset($_GET['forgot']))
   {                             /* email and submit forms and it will display only once the forgot password link been click or true */
       $email = "<form method=\"post\" action=\"\">
                    Enter your email address: <br/>
                    &nbsp;&nbsp;&nbsp; <input type=\"text\" name=\"email\" /><br/>
                    &nbsp;&nbsp;&nbsp; <input type=\"submit\" value=\"submit\"/>
                </form>";

        $connect = new data;

        $sql_query = "SELECT passwordHint FROM int322.users WHERE username = '". $_POST['email']."'";

        $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());

        $result = mysqli_fetch_assoc($run);

        if($result)         /* it will email the password hint from database once the username is match to database */
        {
           mail($_POST["email"], 'Password Hint', $result["passwordHint"]);
           header('Location: login.php');
        }
   }
  if(!$valid || !$_POST)
  {  ?>
    <!DOCTYPE html>
    <html lang ="en">
      <head>
         <meta charset="UTF-8" />
         <title> Assign #1 </title>
         <link rel="stylesheet" type="text/css" href="files.css">
      </head>
     <body>
     <div>
       <h1> Seneca Drug Mart </h1>  
       <img src="http://gigaom2.files.wordpress.com/2013/01/vitamins.jpg" height="240" width="240" /> <br/><br/>
     </div>
     <div class="one">&nbsp;&nbsp;
        <form method="post" action="">
           &nbsp;&nbsp;&nbsp; <?php echo $username; ?><br/>
           &nbsp;&nbsp;&nbsp; <?php echo $password; ?><br/>
           &nbsp;&nbsp;&nbsp; <?php echo $submit; ?> 
           <?php echo $forgot ?><?php echo $email; ?><br/>
      </form>            
     </div>
    </body>
    </html>
<?php 
  } ?>
<?php echo $loginError ?>
<?php include 'library.php'; footer(); ?>
