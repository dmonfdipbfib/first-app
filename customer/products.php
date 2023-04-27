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
				
				<div class="form-title">
					قائمة  الحضانة و الرعاية 
				</div>
				
				<input type="text" placeholder="بحث" class="form-input" id="search_text">
				<hr>
				<select name="category" class="form-input" id="search_section">
					<option value="">القسم</option>
					
					<?php
					
						foreach(categories() as $category)
							echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
					
					?>
					
				</select>
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
		
			var search_text    = "";
			var search_section = 0;
		
			$("#search_text").on('input',function(e){
				search_text = $(this).val();
				loader();
			});
		
			$("#search_section").change(function(){
				search_section = $(this).val();
				loader();
			});
		
			function loader(){
				
				$("#loader").load("ajax/products.php?search="+search_text+"&category="+search_section);
				
			}
			
			loader();
		
		</script>
		
	</body>
</html>