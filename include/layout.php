<?php


function head($title = 'Mars Reality'){
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
			<h1><span>Mars Reality</h1>
		</div>
		
		<div id="menu">
			<ul>
				<li><a href="/" class="active">Home</a></li>
				<li><a href="#">About Me</a></li>
				<li><a href="#">Photos</a></li>
				<li><a href="#">Resources</a></li>
				<li><a href="#">Contact Me</a></li>
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

function endPost(){
?>
				</div>
<?php
}

function foot(){
?>
			</div>
	
		</div>

		<br class="clear" />

	</div>

</div>

<div id="footer" class="fluid">
	Copyright &copy; 2011 Mars Reality. All rights reserved. Design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree Design</a>.
</div>

</body>
</html>

<?php
}


?>
