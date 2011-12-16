<?php

require_once('include/include.php');

check();

head('Welcome');

$db = dbConnect();

startPost('Welcome to Mars Realty', 'November 25, 2011');
?>
<p> Welcome to Mars Realty! This will be more complete as I actually do it!</p>
<a href="projQueries.php">Project Queries</a>
<?php
endPost();

foot();

?>
