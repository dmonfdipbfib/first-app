<?php

	require_once('server.php');
	
	if(is_logged_in())
	{
		login_redirect();
	}
?>
<!DOCTYPE html>
<html>
	<head>
	
		<!-- page title -->
		<title>login</title>
		
		<meta charset="utf-8">
		<!-- including stylesheets files -->
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css">
		<link href="css/datepicker.css" rel="stylesheet" type="text/css">
		<link href="css/style.css" rel="stylesheet" type="text/css">
	
	</head>
	
	<body style="background-image:url(images/1740.jpg);background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover">
	
		<!-- page code here -->

		<div class="bgimage"></div>
		<div class="row justify-content-center login-row ">
			
			<div class="col-md-6 login-panel">
				<div class="form-title">
					تسجيل الدخول
					
	</div>
				
				<div class="login-box" style="background-image:url(images/file44.jpg);background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover">
					
					<form method="post">
						
						<div class="run-into">
						
							<?php
							
								if(isset($_POST['run'])){
									if(!login($_POST['email'], $_POST['password'])){
										echo '<div class="error-message">';
										echo $server_message;
										echo '</div>';
									}else{
										header("location: controller.php");
									}
								}
							
							?>
						
						</div>
						
						<label>البريد الالكترونى</label>
						<input type="email" placeholder="البريد الالكترونى" class="form-input" name="email">
						<hr>
						<label>كلمة السر</label>
						<input type="password" placeholder="كلمة السر" class="form-input" name="password">
						<hr>
						<button class="form-button" type="submit" name="run">
							دخول
						</button>
                        <a href="android.php" class="form-top-button">إنشاء حساب للعملاء</a>
					</form>
                    <a href="company.php" class="form-top-button">إنشاءحساب مستشفي</a>
</form>
<a href="index.php" class="form-top-button">العودة إلي الصفحة الرئيسية</a>
				</div>


				<hr>

				
			</div>
			
		</div>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/custom.js"></script>
	</body>
</html>