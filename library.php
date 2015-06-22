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
   class data{          /* class data were is use to get data info in topsecret file */
     
       public $connect;
       private function datainfo(&$serverName, &$serverUser, &$serverPass, &$serverDb)
       {
           $files = file("/home/gfencabo/secret/topsecret");
           $serverName = trim($files[0]);
           $serverUser = trim($files[1]);
           $serverPass = trim($files[2]);
           $serverDb = trim($files[3]);           
       }
       public function __construct()
       {
          $this->datainfo($serverName, $serverUser, $serverPass, $serverDb);    /* constructor use to connect in database */
          $this->connect = mysql_connect($serverName, $serverUser, $serverPass);
          if(!$connect)
          {
              die('Could not connect: ' . mysql_error());
          }
          mysql_select_db($serverDb);
       }
       public function __destruct()        /* destructor use to close the connection */
       {
          mysqli_close($this->connect);
       }
   }
                             
   function storedata(&$name, &$supplier, &$desc, &$onhand, &$reorder, &$cost, &$price, &$sale)
   {

         $connect = new data;
     
         $item =  mysql_real_escape_string(trim($name));
         $supplier = mysql_real_escape_string(trim($supplier));
         $desc = mysql_real_escape_string(trim($desc));  
         $onhand = mysql_real_escape_string(trim($onhand));
         $reorder = mysql_real_escape_string(trim($reorder));
         $cost = mysql_real_escape_string(trim($cost));
         $price = mysql_real_escape_string(trim($price));
         $sale = mysql_real_escape_string(trim($sale));

         if($sale == "")       /* if sale is blank or unchecked it will replace as value of 'n' */
            $sale = "n";

         $del = "n";           /* insert the values the been enter in form to the database */                                                   

         $sql_query = "INSERT INTO inventory VALUES ('auto','$item','$supplier','$desc','$onhand','$reorder','$cost','$price','$sale','$del')";

         $run = mysqli_query($connect->connect, $sql_query) or die('query failed inserting'. mysql_error());

          mysqli_close($connect);   /* and close the connection soon it updated */
   }
   function head()    /* header function */
   {
      echo  "<div><h1> Seneca Drug Mart </h1>
            <img src=\"http://gigaom2.files.wordpress.com/2013/01/vitamins.jpg\" height=\"240\" width=\"240\" /> <br/><br/>
            </div>";
      echo   "<div class=\"one\">";
      echo   "<table><tr>
               <th> &nbsp;&nbsp; <a href=\"add.php\"> Add </a> &nbsp;&nbsp; </th>
               <th> <a href=\"view.php\"> View All </a> &nbsp;&nbsp; </th>
                  <form method=\"post\" name=\"menu\">
                       <th> Search in description: &nbsp;&nbsp; </th>
                       <th> <input type=\"text\" name=\"search\" value=\"$_POST[search]\"/> </th>
                       <th> <input type=\"submit\"/> &nbsp;&nbsp; </th>
                  </form>"; 
            session_start();
       echo "<th> User: " . $_SESSION[username] . "&nbsp;&nbsp;&nbsp; Role: " . $_SESSION[role] . "&nbsp;&nbsp; </th>";
       echo "<th> <a href=\"logout.php\"> Log out </a></th>
            </tr></table>
            </div>";   
   }
    function footer()      /* footer function */
    {
      echo "<h5> Copyright 2012-2013 Seneca Drug Mart </h5>";
    }
?>
