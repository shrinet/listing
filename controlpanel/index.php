<?php
	session_start();	
	if(!isset($_SESSION['alogname']))
	{
		header("location: https://www.listingpockets.com/controlpanel/login.php");
		exit;
	}
	header("Cache-control: private, no-cache, must-revalidate");
	header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
	header("Pragma: no-cache");
	header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
	define('ACCESS_SUBFILES',true);	
	require_once("../includes/DbConfig.php");
	require_once("classes/admin_functions.php");
	require_once("../includes/general.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo SITE_NAME;?> - Administrator</title>
	<meta http-equiv="content-language" content="en" />
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<style type="text/css">@import "css/jquery.datepick.css";</style> 
<script type="text/javascript" src="js/jquery.datepick.js"></script>

	
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon"/>
<link href="css/styles.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if lte IE 7]>
<link href="css/styles_ie.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<!--[if lte IE 6]>
<link href="css/styles_ie6.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
<script type="text/javascript" src="js/ui.js"></script>

</head>

<body>

<div id="wrap">
	<div id="header">
		<h1><a class="bg1" href="#" title="Home"></a></h1>
		<p id="status">Logged is as <?php echo stripslashes($_SESSION['alogname']);?>, <a href="logout.php" title="Sign Out?">Sign Out?</a></p>
		<span><img class="logo" width="200" height="50" src="../images/logo.png" alt="Pocket Lister">
		<p id="description"></p>
	</div>
	 <div id="sidebar">
    <?php include("left.php");?>
	</div>
	<div id="content">
		
	<?php include("pages.php");?>
	</div>
	<div id="footer">
	</div>
</div>

</body>
</html>
