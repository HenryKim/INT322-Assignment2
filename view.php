<?php/*
   Subject Code: INT322B
   Student Name: Gerald Encabo
   Date Submitted:
   Student Declaration
   I/we declare that the attached assignment is my/our own work in accordance with Seneca Academic Policy. No part of this assignment has been copied manually or electronically from any other source (including web sites) or distributed to other students.
   Name: Gerald Encabo
   Student #: ID 021-099-114
*/?>

<?php if(!$_COOKIE['PHPSESSID'])          /* If user is not log in it will automatically go back to login.php and to able to continue seeing this page user must login first */
      header('Location: login.php'); ?>  
<?php include 'library.php'; head(); ?>

<html lang ="en">
   <head>
      <meta charset="UTF-8" />
      <title> Assign #1 </title>   
      <link rel="stylesheet" type="text/css" href="files.css">  
   </head>
   <body>
         </br></br>
   </body>
</html>
   <?php      
         include 'library.php';
         $connect = new data;     
         $sort = "";   

          if(isset($_GET['sort']))      /* this are condition in sorting data of header link */
          {                             /* so once link been click it will choose which one its is and sort data from a to z */
              if($_GET['sort'] == 'id')
              {
                  $sort = "ORDER BY id";
              }
              else if($_GET['sort'] == 'name')
              {
                  $sort = "ORDER BY itemName";
              }
              else if($_GET['sort'] == 'supplier')
              {
                  $sort = "ORDER BY supplier";
              }
              else if($_GET['sort'] == 'desc')
              {
                  $sort = "ORDER BY descrip";
              }
              else if($_GET['sort'] == 'num')
              {
                   $sort = "ORDER BY onhand";
              }
              else if($_GET['sort'] == 'reorder')
              {
                   $sort = "ORDER BY reorder";
              }
              else if($_GET['sort'] == 'cost')
              {
                   $sort = "ORDER BY cost";
              }
              else if($_GET['sort'] == 'price')
              {
                  $sort = "ORDER BY price";
              }
              else if($_GET['sort'] == 'sale')
              {
                  $sort = "ORDER BY sale";
              }
              else if($_GET['sort'] == 'delete')
              {
                  $sort = "ORDER BY deleted";
              }
              else if($_GET['sort'] == 'restore')
              {
                  $sort = "ORDER BY deleted DESC";
              }
          }

         if($_POST['search'])         /* once search is true it will find the match of the value been type to database and display it in  view.php */
         {
            $sql_query = "SELECT * FROM inventory WHERE descrip LIKE BINARY '%" . mysql_real_escape_string(trim($_POST['search'])) . "%'";
         }
         else{
               $sql_query =  "SELECT * FROM inventory " . $sort; 
             }      

           /* header link */
           $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());

           echo "<table border=\"1\">    
              <tr>                                                               
                 <th> <a href=\"view.php?sort=id\"> ID </a> </th>                 
                 <th> <a href=\"view.php?sort=name\"> Item Name </a> </th>
                 <th> <a href=\"view.php?sort=supplier\"> Supplier </a> </th>
                 <th> <a href=\"view.php?sort=desc\"> Description </a> </th>
                 <th> <a href=\"view.php?sort=num\"> Number On Hand </a> </th>
                 <th> <a href=\"view.php?sort=reorder\"> Reorder Level </a> </th>
                 <th> <a href=\"view.php?sort=cost\"> Cost </a> </th>
                 <th> <a href=\"view.php?sort=price\"> Price </a> </th>
                 <th> <a href=\"view.php?sort=sale\"> On Sale </a> </th>
                 <th> <a href=\"view.php?sort=delete\"> Deleted </a> </th>
                 <th> <a href=\"view.php?sort=restore\"> Delete/Restore </a> </th>
              </tr>";

              while($row = mysqli_fetch_assoc($run))     /* to display data from database to view.php */
              {
                 echo "<tr>";                                    /* this link is to get the values from database and display it in form at add.php once the repopulate is true */ 
                    echo "<td>" . "<a href=\"add.php?id=$row[id]&name=$row[itemName]&supplier=$row[supplier]&desc=$row[descrip]&onhand=$row[onhand]&reorder=$row[reorder]&cost=$row[cost]&price=$row[price]&sale=$row[sale]&repopulate=true\" >" . $row['id'] . "</a>" . "</td>";
                    echo "<td>" . $row['itemName'] . "</td>";
                    echo "<td>" . $row['supplier'] . "</td>";
                    echo "<td>" . $row['descrip'] . "</td>";
                    echo "<td>" . $row['onhand'] . "</td>";
                    echo "<td>" . $row['reorder'] . "</td>";
                    echo "<td>" . $row['cost'] . "</td>";
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td>" . $row['sale'] . "</td>";
                    echo "<td>" . $row['deleted'] . "</td>";
              
                    if($row['deleted'] == "n")
                        $value = "Delete";     /* condition if delete is equal 'n' it will print as delete */
                    else
                        $value = "Restore";    /* if the condition is blank it will print as restore */

                    echo "<td> <a href=\"delete.php?id=$row[id]&deleted=$row[deleted]\">". $value . "</a></td>";  
                 echo "</tr>";                  
              }
           echo "</table>";

           if(mysqli_num_rows($run) == 0)
           {
              echo "<br/>" . "<h1> No record found! </h1>";
           }       
    ?>   
   <?php footer(); ?>
