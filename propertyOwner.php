<?php

require_once('include/include.php');

head('Owner Details');

$id = $_GET['id'];

$db = dbConnect();

if( (!$id && $id != 0) || !is_numeric($id)){
   $propertyQuery = dbExec($db, 'select owner, id, street, city, state from Property');
   
   startPost('Select Property');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[1].' - '.$row[2].' '.$row[3].', '.$row[4].' '.$row[5].'</option>';
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
   $ownerQuery = dbExec($db, "select name, street, city, state, zip, phone, fax, isBusiness from Owner where id = $id");
   
   $row = dbFetchRow($ownerQuery);
   
   startPost('Owner Details');
   
   ?>
   <table>
   <tr>
      <td>Name:</td>
      <td><?php echo $row[0]; ?></td>
   </tr>
   <tr>
      <td>Address:</td>
      <td><?php echo $row[1].'<br>'.$row[2].', '.$row[3].'<br>'.$row[4]; ?></td>
   </tr>
   <tr>
      <td>Phone Number:</td>
      <td><?php echo $row[5]; ?></td>
   </tr>
   <tr>
      <td>Fax Number:</td>
      <td><?php echo $row[6]; ?></td>
   </tr>
   <?php
      if($row[7] == 'Y'){
      $businessQuery = dbExec($db, "select type, contactName from business where id = $id");
      $bRow = dbFetchRow($businessQuery);
      ?>
      <tr>
         <td>Type:</td>
         <td>Business</td>
      </tr>
      <tr>
         <td>Business Type:</td>
         <td><?php echo $bRow[0]; ?></td>
      </tr>
      <tr>
         <td>Contact Name:</td>
         <td><?php echo $bRow[1]; ?></td>
      </tr>
      <?php
      } else {
      ?>
      <tr>
         <td>Type:</td>
         <td>Private Owner</td>
      </tr>
      <?php
      }
   ?>
   </table>
   
   <?php
   
   endPost();
   
   foot();
   
}

?>
