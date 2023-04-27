<?php

	require_once('../../server.php');
	if(!admin_get()) header('location: ../../');
	
	$search = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
	
	foreach(wait4access($search) as $admin){
		?>
		
		<a href="show-company.php?id=<?php echo $admin['id'] ?>&url=new-companies.php" class="list-item">
			<div class="top-name"><?php echo $admin['name'] ?></div>
			<div class="top-email"><?php echo $admin['email'] ?></div>
			<div class="top-img"><img src="../images/<?php echo $admin['logo'] ?>" height="100"/></div>
		</a>
		
		<?php
		
	}
	
?>
