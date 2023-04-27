<?php

	require_once('server.php');
	
	if(is_logged_in()) login_redirect();
	else header('location: ./');
	
?>
