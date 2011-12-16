<?php

require_once('include/include.php');
check();

$db = dbConnect();

if($_POST['submit']){
   $newspaper = $_POST['newspaper'];
   $cost = $_POST['cost'];
   $property = $_POST['property'];
   $date = dbDate($_POST['date']);
   
   
   dbExec($db, "insert into Advertisement (id, property, printDate, cost, newspaperId) values (key_ad.nextval, $property, $date, $cost, $newspaper)");
   
   header('Location: viewAd.php');
}

head('Create Advertisement');

startPost('Create Advertisement');

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<input type="hidden" id="submit" name="submit" value="1" />
<table>
   <tr>
      <td>Newspaper:</td>
      <td>
         <select name="newspaper" id="newspaper">
         <?php
            $newspaperQuery = dbExec($db, 'select id, name, city, state from Newspaper');
            while( ($row = dbFetchRow($newspaperQuery)) ){
               echo '<option value="'.$row[0].'">'.$row[1].' - '.$row[2].', '.$row[3].'</option>';
            }
         ?>
         </select>
      </td>
   </tr>
   <tr>
      <td>Property:</td>
      <td>
         <select id="property" name="property">
         <?php
            $propertyQuery = dbExec($db, 'select id, street, city, state from property where rented = \'N\'');
            
            while( ($row = dbFetchRow($propertyQuery)) ){
               echo '<option value="'.$row[0].'">'.$row[0].' - '.$row[1].', '.$row[2].', '.$row[3].'</option>';
            }
         ?>
         </select>
      </td>
   </tr>
   <tr>
      <td>Print Date: (Ex 12.10.1990)</td>
      <td><input type="text" size="30" id="date" name="date" value="<?php echo $date ?>" /></td>
   </tr>
   <tr>
      <td>Cost:</td>
      <td><input type="text" size="30" id="cost" name="cost" value="<?php echo $cost ?>" /></td>
   </tr>
   <tr>
      <td colspan="2" align="center">
         <input type="submit" value="submit" />
      </td>
   </tr>
</table>
</form>

<?php
endPost();

foot();

?>
