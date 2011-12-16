<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('Private Owners with Multiple Properties');

startPost('Private Owners with Multiple Properties');

$query = dbExec($db, 'select name, street, city, state, zip, phone, fax from Owner where isBusiness = \'N\' and id in (select owner from (select owner, count(id) as num from property group by owner) where num > 1)');

while( ($row = dbFetchRow($query)) ){
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
      <td>Type:</td>
      <td>Private Owner</td>
   </tr>
   </table>
   <br />
   <br />
   <?php
}

endPost();

foot();

?>
