<?php

	require_once('../server.php');
	if(!customer_get()) header('location: ../');
	
	$data = $server_data;
	
	if(!isset($_GET['id'])){
		header('location: ./');
	}
	
	if(!product($_GET['id'])){
		header('location: ./');
	}
	
	$current = $server_data;
	
	if(isset($_GET['delete'])){
		remove('p_order', $_GET['delete']);
		header('location: show-product.php?id='.$current['id']);
	} 
	
	if(isset($_GET['quantity'])){
		if(!new_order($_GET['quantity'], $current['price'], $data['id'], $current['id'],$_GET['Notes'])){
			echo '<script> alert("'.$server_message.'"); </script>';
		}else{
			header('location: show-product.php?id='.$current['id']);
		}
	}
	
	$url = isset($_GET['url']) ? $_GET['url'] : "products.php";
	
?>
<!DOCTYPE html>
<html>
	<head>
	
		<!-- page title -->
		<title><?php echo $data['name'] ?></title>
		
		<meta charset="utf-8">
		<!-- including stylesheets files -->
		<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
		<link href="../css/datepicker.css" rel="stylesheet" type="text/css">
		<link href="../css/style.css" rel="stylesheet" type="text/css">
		
	</head>
	
	<body>
	
		<!-- page code here -->
		
		<?php include('customer_header.php') ?>
		
		<div class="row justify-content-center panel-row">
			
			<div class="col-md-10 login-panel">
				
				<a href="<?php echo $url ?>" class="form-top-button">رجوع</a>
				
				<?php
				
				$offer = get_product_today_offer($current['id']);
				
				if(count($offer)){
					
					if($offer['status']){
						$per = "%" . $offer['discount'];
						$price = ($current['price'] * $offer['discount']) / 100;
						$price = $current['price'] - $price;
					}else{
						$per = " جنية " . $offer['discount'];
						$price = $current['price'] - $offer['discount'];
					}
					
					echo '<div class="success-message">';
					echo 'خصم : ' . $per;
					echo '<hr>';
					echo 'السعر بعد الخصم : ' . $price;
					echo '</div>';
				}
				
				?>
				
				<table class="table">
				
					<tr class="text-right">
						<td><?php echo $current['name'] ?></td>
						<td>الاسم</td>
					</tr>
				
					<tr class="text-right">
						<td><img src="../images/<?php echo $current['image'] ?>" class="global-image-size"/></td>
						<td>الصورة</td>
					</tr>
				
					<tr class="text-right">
						<td><?php echo $current['price'] ?></td>
						<td>السعر</td>
					</tr>
				
					<tr class="text-right">
						<td><?php echo $current['details'] ?></td>
						<td>التفاصيل</td>
					</tr>
				
					<tr class="text-right">
						<td><?php category($current['category_id']); echo $server_data['name'] ?></td>
						<td>القسم</td>
					</tr>
				
					<tr class="text-right">
						<td><?php company($current['company_id']); echo $server_data['name'] ?></td>
						<td>الحرفي</td>
					</tr>
					<tr class="text-right">
					 <?php if(myorder( $data['id'], $current['id']))
					 {
						 ?>
						<td><?php myorder( $data['id'], $current['id']); echo $server_data['Notes'] ?></td>
						<td>ملاحظات</td>
					</tr>
					<?php 
					}
					if(myorder( $data['id'], $current['id']))
					if($server_data['Confirmed'] == 1){
						?>
					<tr class="text-right">
						<td>تمت الموافقة وجاري التواصل </td>
						<td></td>
					</tr>
					<?php 
					}
						?>
					<?php
						
						if(ordered($current['id'], $data['id'])){
							$button = '<button type="button" onClick="unlink(' . "'" . $server_data['id'] . "'" . ')" class="btn btn-danger">الغاء الطلب</button>';
						}else{
							$button = '<button type="button" onClick="order()" class="btn btn-success">طلب</button>';
						}
						
					?>
				
					<tr class="text-right">
						<td></td>
						<td><?php echo $button; ?></td>
					</tr>
				
				</table>
				
			</div>
			
		</div>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/custom.js"></script>
		
		<script>
		
			function order(){
				
				var quantity = prompt(" الحضانة و الرعاية المطلوبة", "0");
				var Notes = prompt("المواصفات", "");
				if(!isNaN(quantity)){
					window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $current['id'] ?>&quantity="+quantity+"&Notes="+Notes+"&url=<?php echo $url ?>";
				}else{
					alert("البيانات غير صحيحة");
				}
				
			}
			
			function unlink(id){
				
				var conf = confirm("تاكيد الالغاء");
				if(!conf) return;
				
				window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $current['id'] ?>&delete="+id+"&url=<?php echo $url ?>";
				
			}
			
		</script>
		
	</body>
</html>