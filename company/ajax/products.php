<?php

	require_once('../../server.php');
	if(!company_get()) header('location: ../');
	
	$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
	
	foreach(products4companies($server_data['id'],$search) as $admin){
		
		category($admin['category_id']);
		
		?>
		
		<a href="show-product.php?id=<?php echo $admin['id'] ?>" class="list-item">
			<div class="top-name"><?php echo $admin['name'] ?></div>
			<div class="top-name"><?php echo $server_data['name'] ?></div>
			<div class="top-img"><img src="../images/<?php echo $admin['image'] ?>" height="100"/></div>
		</a>
		
		<?php
		
	}
	
?>
