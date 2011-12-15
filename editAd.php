<?php

require_once('include/include.php');

$db = dbConnect();

if($_POST['submit']){
   $newspaper = $_POST['newspaper'];
   $cost = $_POST['cost'];
   $property = $_POST['property'];
   $date = dbDate($_POST['date']);
   $id = $_POST['id'];
   
   
   dbExec($db, "update Advertisement set property = $property, printDate = $date, cost = $cost, newspaperId = $newspaper where id = $id");
   
   header('Location: viewAd.php');
}

head('Edit Advertisement');

$id = $_GET['id'];

if((!$id && $id != 0) || !is_numeric($id)){
   
   $propertyQuery = dbExec($db, 'select id, property, TO_CHAR(printDate, \'MM.DD.YYYY\') from Advertisement');
   
   startPost('Edit Advertisement');
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

startPost('Edit Advertisement');

$query = dbExec($db, "select newspaperId, property, TO_CHAR(printDate, 'MM.DD.YYYY'), cost from Advertisement where id = $id");

$row = dbFetchRow($query);

?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
<input type="hidden" id="submit" name="submit" value="1" />
<input type="hidden" id="id" name="id" value="<?php echo $id ?>" />
<table>
   <tr>
      <td>Newspaper:</td>
      <td>
         <select name="newspaper" id="newspaper">
         <?php
            $newspaperQuery = dbExec($db, 'select id, name, city, state from Newspaper');
            while( ($nrow = dbFetchRow($newspaperQuery)) ){
               if($nrow[0] == $row[0]){
                  echo '<option value="'.$nrow[0].'" selected>'.$nrow[1].' - '.$nrow[2].', '.$nrow[3].'</option>';
               } else {
                  echo '<option value="'.$nrow[0].'">'.$nrow[1].' - '.$nrow[2].', '.$nrow[3].'</option>';
               }
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
            while( ($prow = dbFetchRow($propertyQuery)) ){
               if($prow[0] == $row[1]){
                  echo '<option value="'.$prow[0].'" selected>'.$prow[0].' - '.$prow[1].', '.$prow[2].', '.$prow[3].'</option>';
               } else {
                  echo '<option value="'.$prow[0].'">'.$prow[0].' - '.$prow[1].', '.$prow[2].', '.$prow[3].'</option>';
               }
            }
         ?>
         </select>
      </td>
   </tr>
   <tr>
      <td>Print Date: (Ex 12.10.1990)</td>
      <td><input type="text" size="30" id="date" name="date" value="<?php echo $row[2] ?>" /></td>
   </tr>
   <tr>
      <td>Cost:</td>
      <td><input type="text" size="30" id="cost" name="cost" value="<?php echo $row[3] ?>" /></td>
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
