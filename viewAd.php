<?php

require_once('include/include.php');
check();

$db = dbConnect();

head('View Advertisement Details');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   
   $propertyQuery = dbExec($db, 'select id, property, TO_CHAR(printDate, \'MM.DD.YYYY\') from Advertisement');
   
   startPost('Select Advertisement');
   ?>
   <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get">
      <select name="id" id="id">
      <?php
         while( ($row = dbFetchRow($propertyQuery)) ){
            echo '<option value="'.$row[0].'">'.$row[0].' - For Property '.$row[1].' on '.$row[2].'</option>';
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
}

startPost("Advertisement $id Details");

$query = dbExec($db, "select property.id, Property.street, Property.city, Property.state, Property.zip, type, sqfoot, bedrooms, bathrooms, rent, printDate, newspaperId, name, cost from Advertisement, Newspaper, Property where Property.id = Advertisement.property and Newspaper.id = newspaperId and Advertisement.id = $id");

$row = dbFetchRow($query);
?>
<table>
   <tr>
      <td>Property:</td>
      <td><a href="viewProperty.php?id=<?php echo $row[0] ?>">Property <?php echo $row[0] ?></a></td>
   </tr>
   <tr>
      <td>Address:</td>
      <td><?php echo $row[1].'<br>'.$row[2].', '.$row[3].'<br>'.$row[4]; ?></td>
   </tr>
   <tr>
      <td>Type:</td>
      <td><?php echo propertyType($row[5]); ?></td>
   </tr>
   <tr>
      <td>Square Feet:</td>
      <td><?php echo $row[6]; ?></td>
   </tr>
   <tr>
      <td>Bedrooms:</td>
      <td><?php echo $row[7]; ?></td>
   </tr>
   <tr>
      <td>Bathrooms:</td>
      <td><?php echo $row[8]; ?></td>
   </tr>
   <tr>
      <td>Rent:</td>
      <td>$<?php echo $row[9]; ?></td>
   </tr>
   <tr>
      <td>Print Date:</td>
      <td><?php echo $row[10]; ?></td>
   </tr>
   <tr>
      <td>Newspaper:</td>
      <td><a href="viewNewspaper.php?id=<?php echo $row[11]; ?>"><?php echo $row[12]; ?></a></td>
   </tr>
   <tr>
      <td>Advertisement Cost:</td>
      <td><?php echo $row[13]; ?></td>
   </tr>
</table>
<?php

endPost();

foot();

?>
