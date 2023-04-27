<?php

	require_once('../server.php');
	if(!admin_get()) header('location: ../');
	
	$data = $server_data;
?>
<!DOCTYPE html>
<html>
	<head>
	
		<!-- page title -->
		<title><?php echo $data['name'] ?></title>
		
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
				
				<div class="form-title">
					قائمة المديرين
				</div>
				
				<input type="text" placeholder="بحث" class="form-input" id="search_text">
				<div class="list-into" id="loader">
				
				</div>
				
			</div>
			
		</div>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/custom.js"></script>
		
		<script>
		
			var search_text = "";
		
			$("#search_text").on('input',function(e){
				search_text = $(this).val();
				loader();
			});
		
			function loader(){
				
				$("#loader").load("ajax/admins.php?search="+search_text);
				
			}
			
			loader();
		
		</script>
		
	</body>
</html>