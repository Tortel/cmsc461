<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('View Newspaper Details');

$id = $_GET['id'];

if( (!$id && !($id == 0)) || !is_numeric($id) ){
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
   
   $newspaperQuery = dbExec($db, "select name, street, city, state, zip, phone, fax, contactName from Newspaper where id = $id");
   
   $row = dbFetchRow($newspaperQuery);
   
   startPost('Newspaper Details');
   
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
   <tr>
      <td>Contact Name:</td>
      <td><?php echo $row[7] ?></td>
   </tr>
   </table>
   
   <?php
   
   endPost();
   
   foot();
   
}

?>
