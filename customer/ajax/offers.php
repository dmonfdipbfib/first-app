<?php

	require_once('../../server.php');
	if(!customer_get()) header('location: ../');
	
	foreach(today_offers() as $offer){
		
		product($offer['product_id']);
		
		if($offer['status']){
			$per = "%" . $offer['discount'];
			$price = ($server_data['price'] * $offer['discount']) / 100;
			$price = $server_data['price'] - $price;
		}else{
			$per = " جنية " . $offer['discount'];
			$price = $server_data['price'] - $offer['discount'];
		}
		
		?>
		
		<a href="show-product.php?id=<?php echo $server_data['id'] ?>&url=offers.php" class="list-item">
			<div class="top-name"><?php echo $server_data['name'] ?></div>
			<div class="top-name"><?php echo 'خصم : ' . $per ?></div>
			<div class="top-name"><?php echo 'السعر بعد الخصم : ' . $price ?></div>
			<div class="top-img"><img src="../images/<?php echo $server_data['image'] ?>" height="100"/></div>
		</a>
		
		<?php
		
	}
	
?>
