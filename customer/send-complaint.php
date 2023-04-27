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
					ارسال شكوى
				</div>
				
				<div class="login-box">
					
					<form method="post" enctype="multipart/form-data">
						
						<div class="run-into">
						
							<?php
								if(isset($_POST['run'])){
									if(!add_complaint($_POST['subject'], $_POST['details'], $data['id'])){
										echo '<div class="error-message">';
										echo $server_message;
										echo '</div>';
									}else{
										echo '<div class="success-message">';
										echo 'تم ارسال الشكوى بنجاح شكرا لتواصلكم معنا';
										echo '</div>';
									}
								}
							
							?>
						
						</div>
						
						<label>سبب الشكوي</label>
						<input type="text" placeholder="سبب الشكوى" class="form-input" name="subject">
						<hr>
						
						<label>التفاصيل</label>
						<textarea placeholder="التفاصيل" class="form-input" name="details"></textarea>
						<hr>
						
						<button class="form-button" type="submit" name="run">
							ارسال
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