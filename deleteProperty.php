<?php

require_once('include/include.php');
check();

$id = $_GET['id'];

$db = dbConnect();

if((!$id && $id != 0) || !is_numeric($id)){
   head('Delete Property');
   
   $propertyQuery = dbExec($db, 'select id, street, city, state from property');
   
   startPost('Select Property');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].', '.$row[3].'</option>';
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
   
   dbExec($db, "delete from property where id = $id");
   
   header('Location: viewProperty.php');
   
}
?>
