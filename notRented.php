<?php

require_once('include/include.php');
check();

$db= dbConnect();

head('Properties not Rented');

startPost('Properties not Rented in the last Three Months');

//Properties not rented at all
//select id from property where id not in (select property from lease)
//Last 3 months
//select property as id from lease where MONTHS_BETWEEN(CURRENT_DATE, endDate) > 3

$query = dbExec($db, 'Select Property.street, Property.city, property.state, Property.zip, type, bedrooms, bathrooms, sqfoot, minRent, maxRent, rent, posted, lastupdate, rented, associate, name, Owner.id, property.id from Property, owner where property.owner = owner.id and property.id in (select id from property where id not in (select property from lease) union select property as id from lease where MONTHS_BETWEEN(CURRENT_DATE, endDate) > 3)');

while( ($row = dbFetchRow($query)) ){
   ?>
   <b>Property <?php echo $row[17] ?></b>
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
         <td>Min Rent:</td>
         <td>$<?php echo $row[8]; ?></td>
      </tr>
      <tr>
         <td>Max Rent:</td>
         <td>$<?php echo $row[9]; ?></td>
      </tr>
      <tr>
         <td>Rent:</td>
         <td>$<?php echo $row[10]; ?></td>
      </tr>
      <tr>
         <td>Posted:</td>
         <td><?php echo $row[11]; ?></td>
      </tr>
      <tr>
         <td>Last Updated:</td>
         <td><?php echo $row[12]; ?></td>
      </tr>
      <tr>
         <td>Rented:</td>
         <td><?php echo $row[13]; ?></td>
      </tr>
      <tr>
         <td>Managing Assocaite:</td>
         <td><a href="viewEmployee.php?id=<?php echo $row[14]; ?>">Employee <?php echo $row[14]; ?></a></td>
      </tr>
      <tr>
         <td>Owner:</td>
         <td><a href="viewOwner.php?id=<?php echo $row[16]; ?>"><?php echo $row[15]; ?></a></td>
      </tr>
   </table>
   <br />
   <?php
}

endPost();

foot();
?>
