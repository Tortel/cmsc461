<?php

require_once('include/include.php');

$db = dbConnect();

head('Apartments in Baltimore');

startPost('Two Bedrooms in Baltimore for under $1200');

$query = dbExec($db, 'Select Property.street, Property.city, property.state, Property.zip, type, bedrooms, bathrooms, sqfoot, rent, name, Owner.id from Property, owner where property.owner = owner.id and property.type = 0 and rent <= 1200 and bedrooms >= 2');

while( ($row = dbFetchRow($query)) ){
   ?>
   <table>
      <tr>
         <td>Address:</td>
         <td><?php echo $row[0].'<br>'.$row[1].', '.$row[2].'<br>'.$row[3]; ?></td>
      </tr>
      <tr>
         <td>Type:</td>
         <td><?php echo propertyType($row[4]); ?></td>
      </tr>
      <tr>
         <td>Bedrooms:</td>
         <td><?php echo $row[5]; ?></td>
      </tr>
      <tr>
         <td>Bathrooms:</td>
         <td><?php echo $row[6]; ?></td>
      </tr>
      <tr>
         <td>Square Feet:</td>
         <td><?php echo $row[7]; ?></td>
      </tr>
      <tr>
         <td>Rent:</td>
         <td>$<?php echo $row[8]; ?></td>
      </tr>
      <tr>
         <td>Owner:</td>
         <td><a href="viewOwner.php?id=<?php echo $row[10]; ?>"><?php echo $row[9]; ?></a></td>
      </tr>
   </table>
   <?php
}

endPost();

foot();

?>
