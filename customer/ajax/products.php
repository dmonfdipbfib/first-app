<?php

	require_once('../../server.php');
	if(!customer_get()) header('location: ../');
	
	$search   = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : "";
	$category = isset($_GET['category']) && !empty($_GET['category']) ? $_GET['category'] : 0;
	
	foreach(productsSearch($search, $category) as $admin){
		
		category($admin['category_id']);
		
		?>
		
		<a href="show-product.php?id=<?php echo $admin['id'] ?>&url=products.php" class="list-item">
			<div class="top-name"><?php echo $admin['name'] ?></div>
			<div class="top-name"><?php echo $server_data['name'] ?></div>
			<div class="top-img"><img src="../images/<?php echo $admin['image'] ?>" height="100"/></div>
		</a>
		
		<?php
		
	}
	
?>
