<?php

	require_once('../server.php');
	if(!customer_get()) header('location: ../');
	
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
		
		<?php include('customer_header.php') ?>
		
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
				
				</table>
				
			</div>
			
		</div>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/custom.js"></script>
	</body>
</html>