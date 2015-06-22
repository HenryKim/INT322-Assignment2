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

    if(!$_COOKIE['PHPSESSID'])               /* If user is not log in it will automatically go back to login.php */
         header('Location: login.php');      /*and to able to continue seeing this page user must login first */
    if($_POST)
    {

        $tempName = mysql_real_escape_string(trim($_POST['name']));
        $tempSupplier = mysql_real_escape_string(trim($_POST['supplier']));     /* Passing Values that been enter from forms */
        $tempDesc = mysql_real_escape_string(trim($_POST['desc']));             /* Trim will cut the spaces before and after of word */  
        $tempOnhand = mysql_real_escape_string(trim($_POST['onhand']));         /* while mysq_real_escape_string is use for eliminating injection attack from hackers */
        $tempOrder = mysql_real_escape_string(trim($_POST['reorder']));
        $tempCost = mysql_real_escape_string(trim($_POST['cost']));
        $tempPrice = mysql_real_escape_string(trim($_POST['price']));
        $tempSale = mysql_real_escape_string(trim($_POST['sale']));
        $validData = true;
        $checker = true;
        $idtext = ""; 
                 
        if($_GET['repopulate'])       /* once $_GET is true, the validDAta and $_GET will be set to false */
        {
            $validData = false;
            $_GET['repopulate'] = false;
        }

        if($tempSale == "")
            $tempSale = "n";

        if($_POST['name'] == "")                   /* Validation */
          {                                             
	       $nameError = "<--- Cannot be blank!";    /* Error Message once it Blank */
               $validData = false;
               $checker = false; 
          }
        else if(preg_match("/^[\s]*$/", $_POST['name']))
          {
               $nameError = "<--- Cannot contain spaces only!!";       
               $validData = false;
               $checker = false; 
          }   
        else if(!preg_match("/^[a-zA-Z\s]*$/", $_POST['name']))
          {
               $nameError = "<--- Must Contain letters and spaces only!";  
               $validData = false;
               $checker = false;
          }
        if($_POST['supplier'] == "")
          {
               $supplierError = "<--- Cannot be blank!";
               $validData = false;
               $checker = false;
          }
        else if(preg_match("/^[\s]*$/", $_POST['supplier']))
          {
               $supplierError = "<--- Cannot contain spaces only!!";
               $validData = false;
          }
        else if(!preg_match("/^[a-zA-Z\s-]*$/", $_POST['supplier']))
          {
               $supplierError = "<--- Must Contain letters, spaces and dashes only!";
               $validData = false;
               $checker = false;
          }      
        if($_POST['desc'] == "")
          {
               $descError = "<--- Cannot be blank!";
               $validData = false;
               $checker = false;
          }
        else if(preg_match("/^[\s]*$/", $_POST['desc']))   /* Error message once it contain spaces only */
          {
               $descError = "<--- Cannot contain spaces only!!";
               $validData = false;
          }
        else if(!preg_match("/^[a-zA-Z0-9,'-\s]*$/", $_POST['desc']))   
          {
               $descError = "<--- Must Contain letters, digits, periods, commas, apostrophes, dashes and spaces only!";
               $validData = false;
               $checker = false;
          }      
        if($_POST['onhand'] == "")
          {
               $numError = "<--- Cannot be blank!";
               $validData = false;
               $checker = false;
          }     
        else if(preg_match("/^[\s]*$/", $_POST['onhand']))
          {
                $numError = "<--- Cannot be Spaces only!";
                $validData = false;              
                $checker = false;
          }
        else if(!preg_match("/^[0-9\s]*$/", $_POST['onhand']))
          {
                $numError = "<--- Must contain digits only!";
                $validData = false;    
                $checker = false;
          }
       if($_POST['reorder'] == "")
          { 
                $reorderError = "<--- Cannot be blank!";
                $validData = false;
                $checker = false;
          }
       else if(preg_match("/^[\s]*$/", $_POST['reorder']))
          {
               $reorderError = "<--- Cannot be spaces only!";
               $validData = false;
               $checker = false;
          }
       else if(!preg_match("/^[0-9\s]*$/", $_POST['reorder']))
          {
               $reorderError = "<--- Must contain digits only!";
               $validData = false;
               $checker = false;
          }
       if($_POST['cost'] == "")                      /* Error Message once it Blank */
          {
               $costError = "<--- Cannot be blank";
               $validData = false;
               $checker = false;
          }
       else if(!preg_match("/^[0-9\s]*[.]{1}[0-9]{2}[\s]*$/", $_POST['cost']))
          {
               $costError = "<--- Must contain amount monetary only! i.e.(1234.10)";   
               $validData = false;
               $checker = false;
          }
       if($_POST['price'] == "")
          {
               $priceError = "<--- Cannot be blank";
               $validData = false;
               $checker = false;
          }
       else if(!preg_match("/^[0-9\s]*[.]{1}[0-9]{2}[\s]*$/", $_POST['price'])) 
          {
               $priceError = "<--- Must contain amount monetary only! i.e.(1234.10)";
               $validData = false;
               $checker = false;
          }
    }
    if($validData)     /* checking if validData is true */
    { 
          include 'library.php';                                   /* Calling function from library.php */
          storedata($tempName, $tempSupplier, $tempDesc, $tempOnhand, $tempOrder, $tempCost, $tempPrice, $tempSale);          
          header('Location: view.php');          /* header will locate this page to view.php after the function call */   
    }
    if($_GET['id'])         /* checking if $_GET['id'] is true */
    {          
       include 'library.php';    /* Get data info in library page and set it to connect */
       $connect = new data;

       $id = $_GET['id'];  /* Get id number from database */

       $idtext = "ID: <input type=\"text\" name=\"id\" value=\"$id\" readonly=\"readonly\" />" . "<br/><br/>";  /* it will display the id form */

       $sql_query = "SELECT * FROM inventory WHERE id='$id' OR itemName='$name' OR supplier='$supplier' OR descrip='$desc' OR onhand='$onhand' OR reorder='$reorder' OR cost='$cost' OR price='$price' OR sale='$sale'"; 
     
       $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());

       if(mysql_num_rows($run) >= 1 && $checker)      /* check if $run is equal 1 or more and if $checker is true otherwise it will update the database */
       {
          $sql_query = "UPDATE inventory SET itemName = '$tempName', supplier = '$tempSupplier', descrip = '$tempDesc', onhand = '$tempOnhand', reorder = '$tempOrder', cost = '$tempCost', price = '$tempPrice', sale = '$tempSale' WHERE id='$id'";

          $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());
          header('Location: view.php');
                                        /* once it update succesfully it will go to view.php */                
       }            
    } 
  ?>
     
 <?php include 'library.php'; head(); ?>  <?php /* it will call the function head() in library.php to diplay the header */ ?>
       
 <html lang ="en">
    <head>
         <meta charset="UTF-8" />
         <title> Assign #1 </title>
         <link rel="stylesheet" type="text/css" href="files.css">     
    </head>
    <body>               
         <form name="assign2" method="post"> 
           <div><br/><br/>                <?php /* $_GET['repopulate'] is use to display data from database so that it would easy to change and doesn't to re-type all of it just the necessary one */ ?>
                <?php echo $idtext ?> 
                Item name: <input type="text" name="name" value="<?php echo $_POST['name']; if($_GET['repopulate']) echo $_GET['name'];  ?>" /><?php echo $nameError; ?><br/><br/>
                Supplier: <input type="text" name="supplier" value="<?php echo $_POST['supplier'];  if($_GET['repopulate']) echo $_GET['supplier']; ?>" /><?php echo $supplierError; ?><br/><br/> 
                Description: <textarea name="desc" cols="20" rows="5"><?php echo $_POST['desc'];  if($_GET['repopulate']) echo $_GET['desc'] ?></textarea><?php echo$descError; ?><br/><br/>
                Number on hand: <input type="text" name="onhand" value="<?php echo $_POST['onhand']; if($_GET['repopulate']) echo $_GET['onhand'] ?>" /><?php echo $numError; ?><br/><br/>
                Reorder level:  <input type="text" name="reorder" value="<?php echo $_POST['reorder']; if($_GET['repopulate']) echo $_GET['reorder'] ?>" /><?php echo $reorderError; ?><br/><br/> 
                Cost: <input type="text" name="cost" value="<?php echo $_POST['cost']; if($_GET['repopulate']) echo $_GET['cost'] ?>" /><?php echo $costError; ?><br/><br/>
                Selling price: <input type="text" name="price" value="<?php echo $_POST['price']; if($_GET['repopulate']) echo $_GET['price'] ?>" /><?php echo $priceError; ?><br/><br/>
                On sale: <input type="checkbox" name="sale" value="y" <?php if($_POST['sale'] !="" || $_GET['repopulate']  && $_GET['sale'] == "y") echo"checked=checked"; ?>" /><br><br/>
                <input type="submit" value="Submit"/><br/>
    	   </div>
         </form>
     </body>
  </html>       <?php /* it will call the function footer() in library.php to diplay the footer */ ?>
  <?php footer(); ?>
