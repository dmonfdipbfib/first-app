<?php

	require_once('../server.php');
	if(!admin_get()) header('location: ../');
	
	logout();
	
	header('location: ../');
	
?>