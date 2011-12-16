<?php

require_once('include/include.php');
check();

head('City Branch Details');

$city = $_GET['city'];

$db = dbConnect();

if(!strlen($city)){
   //Branch not selected, show option to select one
   
   $cityQuery = dbExec($db, 'select unique(city) from Branch order by City desc');
   
   startPost('Available Cities');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="city" id="city">
      <?php
         while( ($row = dbFetchRow($cityQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].'</option>';
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
   
   startPost("Properties in $city, ordered by rent");
   
   $query = dbExec($db, "Select Property.street, Property.city, property.state, Property.zip, type, bedrooms, bathrooms, sqfoot, rent, name, Owner.id from Property, owner where property.owner = owner.id and property.city = '$city' order by rent asc");
   
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
      <br />
      <?php
   }
   
   endPost();
   
   foot();
}
?>
