<?php


function head($title = 'Mars Reality'){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="index.php">Mars Reality</a></h1>
		<!-- <h2>By NodeThirtyThree + FreeCSSTemplates</h2> -->
	</div>
	<div id="menu">
		<ul>
			<li class="active"><a href="#"> home</a></li>
			<li><a href="#">photos</a></li>
			<li><a href="#">about</a></li>
			<li><a href="#">links</a></li>
			<li><a href="#">contact </a></li>
		</ul>
	</div>
</div>
<!-- end header -->

<!-- start page -->
<div id="page">
	<!-- start content -->
	<div id="content">
<?php

}


function startPost($title = ''){

?>
		<div class="post">
			<h1 class="title"><?php echo $title; ?></h1>
			<div class="entry">
<?php
}

function endPost($date = ''){
?>
			</div>
			<div class="meta">
				<p class="byline"><?php echo $date; ?></p>
				<!-- <p class="links"><a href="#" class="more">Read full article</a> <b>|</b> <a href="#" class="comments">Comments (32)</a></p> -->
			</div>
		</div>
<?php
}

function footer(){
?>
	<!-- end content -->
   </div>
</div>

<!-- start footer -->
<div id="footer">
	<div class="wrap">
		<div id="fbox1" class="box2">
			<h2><b>Lorem</b> Ipsum</h2>
			<p>Curabitur tellus. Phasellus tellus <a href="#">turpis iaculis</a> in, faucibus lobortis, posuere in, lorem. Donec a ante. Donec neque purus, adipiscing id <a href="#">eleifend a cursus</a> vel odio. Vivamus varius justo amet porttitor iaculis, ipsum massa aliquet nulla, non elementum mi elit a mauris. In hac habitasse platea.</p>
		</div>
		<div id="fbox2" class="box2">
			<h2><b>Metus</b> Nonummy</h2>
			<ul>
				<li><a href="#">Magna lacus bibendum mauris</a></li>
				<li><a href="#">Nec metus sed donec</a></li>
				<li><a href="#">Velit semper nisi molestie</a></li>
				<li><a href="#">Consequat sed cursus</a></li>
				<li><a href="#">Eget tempor eget nonummy</a></li>
			</ul>
		</div>
		<div id="fbox3" class="box2">
			<h2><b>Metus</b> Nonummy</h2>
			<ul>
				<li><a href="#">Magna lacus bibendum mauris</a></li>
				<li><a href="#">Nec metus sed donec</a></li>
				<li><a href="#">Velit semper nisi molestie</a></li>
				<li><a href="#">Consequat sed cursus</a></li>
				<li><a href="#">Eget tempor eget nonummy</a></li>
			</ul>
		</div>
	</div>
	<p id="legal">(c) 2011 Mars Reality. Design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree</a> and <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>.</p>
</div>
<!-- end footer -->
</body>
</html>

<?php
}


?>
