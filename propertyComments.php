<?php

require_once('include/include.php');
check();

head('Property Comments');

$id = $_GET['id'];

$db = dbConnect();

if( (!$id && $id != 0) || !is_numeric($id)){
   $propertyQuery = dbExec($db, 'select id, street, city, state from Property');
   
   startPost('Select Property');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].' '.$row[2].', '.$row[3].' '.$row[4].'</option>';
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
   startPost('Property Comments');
   
   $query = dbExec($db, "select lastName, firstName, viewDate, comments from Viewing, Client where viewing.client = Client.id and Viewing.propertyId = $id");
   
   while( ($row = dbFetchRow($query)) ){
   ?>
   <table>
      <tr>
         <td>Client Name:</td>
         <td><?php echo $row[0].', '.$row[1]; ?></td>
      </tr>
      <tr>
         <td>Date:</td>
         <td><?php echo $row[2]; ?></td>
      </tr>
      <tr>
         <td>Comments:</td>
         <td><?php echo nl2br($row[3]); ?></td>
      </tr>
   </table>
   <br />
   <?php
   }
   
   endPost();
   
   foot();
}
?>
