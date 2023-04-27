<?php

	require_once('../../server.php');
	if(!admin_get()) header('location: ../../');
	
	$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
	
	foreach(categories($search) as $admin){
		?>
		
		<a href="show-category.php?id=<?php echo $admin['id'] ?>" class="list-item">
			<div class="top-name"><?php echo $admin['name'] ?></div>
			<div class="top-img"><img src="../images/<?php echo $admin['photo'] ?>" height="100"/></div>
		</a>
		
		<?php
		
	}
	
?>
