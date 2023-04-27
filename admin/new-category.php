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
				
				<div class="form-title">
اضافه قسم
				</div>
<div class="login-box"style="background-image:url(images/file44-img.png);background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover">
				
				<div class="login-box">
		              

	
					<form method="post" enctype="multipart/form-data">
						
						<div class="run-into">
						
							<?php
							
								if(isset($_POST['run'])){
									if(!new_category($_POST['name'], $_FILES['file'], $data['id'])){
										echo '<div class="error-message">';
										echo $server_message;
										echo '</div>';
									}else{
										echo '<div class="success-message">';
										echo 'تم الاضافة بنجاح';
										echo '</div>';
									}
								}
							
							?>
						
						</div>
						
						<label>اسم القسم</label>
						<input type="text" placeholder="اسم القسم" class="form-input" name="name">
						<hr>
						<label>الصورة</label>
						<input type="file" class="form-input" name="file">
						<hr>
						
						<button class="form-button" type="submit" name="run">
							اضافة
						</button>
						
					</form>
					
				</div>
				
			</div>
			
		</div>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/custom.js"></script>
	</body>
</html>