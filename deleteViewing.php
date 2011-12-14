<?php

require_once('include/include.php');

$db = dbConnect();

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   head('View Viewing');
   $viewQuery = dbExec($db, 'select id, propertyId, TO_CHAR(viewDate, \'DD.MM.YYYY\') from viewing');
   
   startPost('Select Viewing');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($viewQuery)) ){
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
} else {
   
   dbExec($db, "delete from viewing where id = $id");
   
   header("Location: viewViewing.php");
   
}
?>
