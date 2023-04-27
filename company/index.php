<?php

	require_once('../server.php');
	if(!company_get()) header('location: PublicHome/');
	
	$data = $server_data;
	
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
				
				<table class="table">
				
					<tr class="text-right">
						<td><?php echo $data['name'] ?></td>
						<td>الاسم</td>
					</tr>
				
					<tr class="text-right">
						<td><?php echo $data['email'] ?></td>
						<td>البريد الالكترونى</td>
					</tr>
				
					<tr class="text-right">
						<td><img class="global-image-size" src="../images/<?php echo $data['logo'] ?>" /></td>
						<td>الصورة</td>
					</tr>
				
				</table>
				
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
	</body>
</html>