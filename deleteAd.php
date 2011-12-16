<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('Delete Advertisement');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   
   $propertyQuery = dbExec($db, 'select id, property, TO_CHAR(printDate, \'MM.DD.YYYY\') from Advertisement');
   
   startPost('Delete Advertisement');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - For Property '.$row[1].' on '.$row[2].'</option>';
         }
      ?>
      </select>
      
      <br>
      <input type="submit" value="Submit">
   </form>
   <?php
   
   endPost();
   
   foot();
   
   exit();
}

dbExec($db, "delete from advertisement where id = $id");

header('Location: viewAd.php');

?>
