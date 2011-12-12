<?php

require_once('include/include.php');

$db = dbConnect();

head('View Owner Details');

$id = $_GET['id'];

if( (!$id || !($id == 0)) || !is_numeric($id) ){
   $ownersQuery = dbExec($db, 'select id, name, city, state from Owner');
   
   startPost('Select Owner');
   
   ?>
   
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($ownersQuery)) ){
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
