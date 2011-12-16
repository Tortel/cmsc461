<?php

require_once('include/include.php');

check();

head('Welcome');

$db = dbConnect();

startPost('Welcome to Mars Realty');
?>
<p> Welcome to Mars Realty!</p>
<?php
endPost();

foot();

?>
