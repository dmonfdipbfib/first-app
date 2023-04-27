<?php

	require_once('../server.php');
	if(!admin_get()) header('location: ../');
	
	$data = $server_data;
	
	if(isset($_GET['delete'])){
		remove('admin', $_GET['delete']);
		header("location: admins.php");
		return;
	}
	
	if(!isset($_GET['id'])){
		header('location: ./');
	}
	
	if(!admin($_GET['id'])){
		header('location: ./');
	}
	
	$current = $server_data;
	
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
		
		<?php include('admin_header.php') ?>
		
		<div class="row justify-content-center panel-row">
			
			<div class="col-md-10 login-panel">
				
				<a href="admins.php" class="form-top-button">رجوع</a>
				
				<table class="table">
				
					<tr class="text-right">
						<td><?php echo $current['name'] ?></td>
						<td>الاسم</td>
					</tr>
				
					<tr class="text-right">
						<td><?php echo $current['email'] ?></td>
						<td>البريد الالكترونى</td>
					</tr>
				
					<?php
					
						$disabled = $current['id'] == $data['id'] ? "disabled" : "";
						
					?>

					<tr class="text-right">
						<td><a href="update-admin.php?id=<?php echo $current['id'] ?>" class="btn btn-warning">تعديل</a></td>
						<td><button type="button" onClick="unlink('<?php echo $current['id'] ?>')" class="btn btn-danger" <?php echo $disabled ?>>حذف</button></td>
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
		
			function unlink(id){
				
				var conf = confirm("تاكيد الحذف");
				if(!conf) return;
				
				window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?delete="+id;
				
			}
		
		</script>
		
	</body>
</html>