<?php

	require_once('../../server.php');
	if(!admin_get()) header('location: ../../');
	
	$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
	
	foreach(customers($search) as $admin){
		?>
		
		<a href="javascript:void(0)" class="list-item">
			<div class="top-name"><?php echo $admin['name'] ?></div>
			<div class="top-email"><?php echo $admin['email'] ?></div>
		</a>
		
		<?php
		
	}
	
?>
