<?php

	require_once('../../server.php');
	if(!customer_get()) header('location: ../');
	
	foreach(orders4customer($server_data['id']) as $offer){
		
		product($offer['product_id']);
		
		?>
		
		<a href="show-product.php?id=<?php echo $server_data['id'] ?>&url=orders.php" class="list-item">
			<div class="top-name"><?php echo $server_data['name'] ?></div>
			<div class="top-img"><img src="../images/<?php echo $server_data['image'] ?>" height="100"/></div>
		</a>
		
		<?php
		
	}
	
?>
