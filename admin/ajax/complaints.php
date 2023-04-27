<?php

	require_once('../../server.php');
	if(!admin_get()) header('location: ../../');
	
	$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
	
	foreach(complaints($search) as $admin){
		
		customer($admin['customer_id']);
		
		?>
		
		<a href="show-complaint.php?id=<?php echo $admin['id'] ?>" class="list-item">
			<div class="top-name"><?php echo $admin['subject'] ?></div>
			<div class="top-email"><?php echo $server_data['name'] ?></div>
		</a>
		
		<?php
		
	}
	
?>
