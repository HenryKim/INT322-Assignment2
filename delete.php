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

    if(isset($_SESSION['username']))
    {

      include 'library.php';
      $connect = new data;
 
       if($_GET['deleted'] == "n")    /* If deleted is equal to 'n' it will update to 'y' or other way if the compiler try to change it */
       {
            $sql_query = "UPDATE inventory SET deleted='y' WHERE id='". $_GET['id'] . "'";
       }                                     
       else{                                   
            $sql_query = "UPDATE inventory SET deleted='n' WHERE id='" . $_GET['id']. "'";
           }          
                                     
       echo $sql_query;      /* print the value and run it*/

       $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());
  
       mysqli_close($connect);   /* Close the file after updating it */

       header('Location: view.php');    
    }
?>
