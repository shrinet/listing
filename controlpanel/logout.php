<?php

	session_start();

	session_destroy();

	header("location: https://www.listingpockets.com/controlpanel/login.php");

?>