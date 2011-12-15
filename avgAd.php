<?php

require_once('include/include.php');

$db = dbConnect();

head('Properties Advertised more than Average');

startPost('Properties advertised mroe than average');

$query = dbExec($db, 'select property from (select property, count(id) as count from advertisement group by property) where count > (select count(id)/count(unique property) from advertisement)');

echo '<ul>';
while( ($row = dbFetchRow($query)) ){
   echo "<li><a href=\"viewProperty.php?id=$row[0]\">Property $row[0]</a></li>";
}
echo '</ul>';

endPost();
foot();

//Average advertised
// select count(id)/count(unique property) from advertisement
?>
