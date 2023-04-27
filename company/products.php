<?php

	require_once('../server.php');
	if(!company_get()) header('location: ../');
	
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
				
				<div class="form-title">
					قائمة  الحضانة و الرعاية
				</div>
				
				<input type="text" placeholder="بحث" class="form-input" id="search_text">
				<div class="list-into" id="loader">
				
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
		
			var search_text = "";
		
			$("#search_text").on('input',function(e){
				search_text = $(this).val();
				loader();
			});
		
			function loader(){
				
				$("#loader").load("ajax/products.php?search="+search_text);
				
			}
			
			loader();
		
		</script>
		
	</body>
</html>