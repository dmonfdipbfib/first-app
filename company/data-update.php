<?php

	require_once('../server.php');
	if(!company_get()) header('location: ../');
	
	$data = $server_data;
	$current = $data;
	
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
		
		
		<div class="row justify-content-center panel-row">
			
			<div class="col-md-10 login-panel">
				
				<div class="form-title">
					تعديل البيانات الشخصية
				</div>
				
				<div class="login-box">
					
					<form method="post" enctype="multipart/form-data">
						
						<div class="run-into">
						
							<?php
							
								if(isset($_POST['run'])){
									if(!update_company($_POST['name'], $_POST['email'], $_FILES['file'], $_POST['password'], $_POST['confirm'], $current['id'])){
										echo '<div class="error-message">';
										echo $server_message;
										echo '</div>';
									}else{
										echo '<div class="success-message">';
										echo 'تم التعديل بنجاح';
										echo '</div>';
									}
								}
							
								if(company_get()){
									$current = $server_data;
								}
								
							?>
						
						</div>
						
						<label>اسم المستشفي</label>
						<input type="text" placeholder="اسم المستشفي" class="form-input" name="name" value="<?= $current['name'] ?>">
						<hr>
						<label>البريد الالكترونى</label>
						<input type="email" placeholder="البريد الالكترونى" class="form-input" name="email" value="<?= $current['email'] ?>">
						<hr>
						<label>الصورة</label>
						<input type="file" class="form-file" name="file">
						<image src="../images/<?= $current['logo'] ?>" height="100">
						<hr>
						<label>كلمة السر</label>
						<input type="password" placeholder="كلمة السر" class="form-input" name="password">
						<hr>
						<label>تاكيد كلمة السر</label>
						<input type="password" placeholder="تاكيد كلمة السر" class="form-input" name="confirm">
						<hr>
						
						<button class="form-button" type="submit" name="run">
							تعديل
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