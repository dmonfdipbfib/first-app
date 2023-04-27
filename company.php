<?php

	require_once('server.php');
	require_once('variables.php');
	
	if(is_logged_in()) login_redirect();
	
?>
<!DOCTYPE html>
<html>
	<head>
	
		<!-- page title -->
		<title>نظام </title>
		
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

		
		<div class="row justify-content-center login-row">
			
			<div class="col-md-6 login-panel">
				
				<div class="form-title">
				إنشاء حساب مستشفي
				</div>
				
				<div class="login-box" style="background-image:url(images/111111.jpg);background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover">

					<form method="post" enctype="multipart/form-data">

						<div class="run-into">

							<?php

								if(isset($_POST['run'])){
									if(!company_create($_POST['name'], $_POST['email'], $_FILES['logo'], $_POST['password'], $_POST['confirm'])){
										echo '<div class="error-message">';
										echo $server_message;
										echo '</div>';
									}else{
										header("location: controller.php");
									}
								}

							?>

						</div>

						<label> أسم المستشفي</label>
						<input type="text" placeholder="أسم المستشفي" class="form-input" name="name">
						<hr>
						<label>البريد الالكترونى</label>
						<input type="email" placeholder="البريد الالكترونى" class="form-input" name="email">
						<hr>
						<label>كلمة السر</label>
						<input type="password" placeholder="كلمة السر" class="form-input" name="password">
						<hr>
						<label>تاكيد كلمة السر</label>
						<input type="password" placeholder="تاكيد كلمة السر" class="form-input" name="confirm">
						<hr>
						<label>صورة المستشفي</label>
						<input type="file" name="logo" class="form-file">
						<hr>
						<button class="form-button" type="submit" name="run">
							تسجيل
						</button>

					</form>
                    <a href="android.php" class="form-top-button">إنشاء حساب للعملاء</a>
                    <hr>
                    <a href="Login.php" class="form-top-button">تسجيل دخول</a>
<hr>
<a href="index.php" class="form-top-button">العودة إلي الصفحة الرئيسية</a>
				</div>
				

				
			</div>
			
		</div>
		
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/custom.js"></script>
	</body>
</html>