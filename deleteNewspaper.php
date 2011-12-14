<?php

require_once('include/include.php');

$db = dbConnect();

$id = $_GET['id'];

if( (!$id && !($id == 0)) || !is_numeric($id) ){   
   head('Delete Newspaper');
   
   $newspaperQuery = dbExec($db, 'select id, name, city, state from Newspaper');
   
   startPost('Select Newspaper');
   
   ?>
   
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($newspaperQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[1].' - '.$row[2].', '.$row[3].'</option>';
         }
      ?>
      </select>
      <input type="submit" value="Submit">
   </form>
   
   <?php
   
   endPost();
   
   foot();
   
   exit();
   
} else {
   
   dbExec($db, "Delete from newspaper where id = $id");
   
   header('Location: viewNewspaper.php');
   
}
?>
