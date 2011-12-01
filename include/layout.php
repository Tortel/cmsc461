<?php

/**
 * Displays the page header, and uses the given string as the title
 */
function head($title = 'Mars Realty'){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title; ?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>

<div id="header">

	<div id="header_inner" class="fluid">

		<div id="logo">
			<h1><span>Mars Realty</h1>
		</div>
		
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="create.php">Manage Data</a></li>
				<li><a href="#">Something</a></li>
				<li><a href="#">Something</a></li>
				<li><a href="#">Something</a></li>
			</ul>
		</div>
		
	</div>
</div>

<div id="main">

	<div id="main_inner" class="fluid">

		<div id="primaryContent_columnless">

			<div id="columnA_columnless">
			<!-- Content -->
<?php

}


/**
 * Creates the header to start a content 'post'
 */
function startPost($title = '', $date = ''){

?>
				<div class="post">
					<h3><?php echo $title; ?></h3>
					<ul class="post_info">
					   <?php
					      if( $date != '') {
					         echo "<li class=\"date\"> $date </li>";
					      }
					   ?>
					</ul>					
<?php
}

/**
 * Closes a content 'psot'
 */
function endPost(){
?>
				</div>
<?php
}

/**
 * The footer for the page layout.
 * This also closes any leftover database connections
 */
function foot(){
//Check theres no database connection left open
if($db){
   oci_close($db);
}

?>
			</div>
	
		</div>

		<br class="clear" />

	</div>

</div>

<div id="footer" class="fluid">
	Copyright &copy; 2011 Mars Realty. All rights reserved. Design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree Design</a>.
</div>

</body>
</html>

<?php
}


?>
