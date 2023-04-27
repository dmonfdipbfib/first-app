<?php

	require_once('../server.php');
	if(!company_get()) header('location: ../');
	
	$data = $server_data;
	
	if(isset($_GET['delete'])){
		remove('p_order', $_GET['delete']);
		header("location: orders.php");
		return;
	}
		if(isset($_GET['approve'])){
		if(!approve($_GET['approve'])){
		echo '<script> alert("'.$server_message.'"); </script>';
		}else{
			echo '<script> alert("تم الموافقة"); </script>';
			header("location: orders.php");
		}
		}
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
		
		<?php include('company_header.php') ?>
		
		<?php
					
			if(!$data['access']){
				echo '<div class="row justify-content-center panel-row">';
				echo '<div class="col-md-10 login-panel">';
				echo '<h1 style="text-align: center;">فى انتظار الموافقة على الحساب</h1>';
				echo '</div>';
				echo '</div>';
			}else{
			
		?>
		
		<div class="row justify-content-center panel-row">
			
			<div class="col-md-10 login-panel">
				
				<div class="form-title">
					الطلبات
				</div>
				
				<div class="table-responsive">
					<table class="table" id="offers">
						<tr>
							<td> الحضانة و الرعاية</td>
							<td>العميل</td>
							<td>الاوقات</td>
							<td>ملحوظات</td>
							<td>الموافقة</td>
							<td>حذف</td>
							<td>موافقة</td>
						</tr>
						
						<?php
						
						foreach(orders4companies($data['id']) as $offer){
							product($offer['product_id']);
							$product_data = $server_data;
							
							customer($offer['customer_id']);
							$customer_data = $server_data;
							
						?>
						
						<tr>
							<td><?php echo $product_data['name'] ?></td>
							<td><?php echo $customer_data['name'] . "<br>" . $customer_data['email']; ?></td>
							<td><?php echo $offer['quantity']; ?></td>
						<td><?php echo $offer['Notes']; ?></td>
							<td><?php if($offer['Confirmed'] == 0) {echo 'No';} else{echo 'Yes'; }?></td>
							<td>
								<button type="button" class="btn btn-danger" onClick="unlinkOrder('<?php echo $offer['id'] ?>')">X</button>
							</td>
							<td>
								<button type="button" class="btn btn-success" onClick="approve('<?php echo $offer['id']?>' )">Approve</button>
							</td>
						</tr>
						
						<?php
						}
						?>
						
					</table>
				</div>
				
			</div>
			
		</div>
		
		<?php
			}
		?>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/custom.js"></script>
		
		<script>
		
			function unlinkOrder(id){
				
				var conf = confirm("تاكيد الحذف");
				if(!conf) return;
				
				window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?delete="+id;
				
			}
			function approve(id){
				
				var conf = confirm("تأكيد الطلب");
				if(!conf) return;
				window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?approve="+id;
				
			}
		</script>
		
	</body>
</html>