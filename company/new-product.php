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
					اضافة الحضانة
				</div>
				
				<div class="login-box">
					
					<form method="post" enctype="multipart/form-data">
						
						<div class="run-into">
						
							<?php
							
								if(isset($_POST['run'])){
									if(!new_product($_POST['name'], $_POST['price'], $_FILES['file'], $_POST['details'], $data['id'], $_POST['category'])){
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
						
						<label> اسم الحضانة او الرعاية</label>
						<input type="text" placeholder="اسم الحضانة او الرعاية" class="form-input" name="name">
						<hr>
						<label>الصورة</label>
						<input type="file" class="form-input" name="file">
						<hr>
						<label>أسعار الحضانة و الرعاية</label>
						<input type="text" placeholder="اسعار  الحضانة و الرعاية" class="form-input" name="price">
						<hr>
						<label>التفاصيل</label>
						<textarea placeholder="التفاصيل" class="form-input" name="details"></textarea>
						<hr>
						<label>القسم</label>
						<select name="category" class="form-input">
							<option value="">القسم</option>
							
							<?php
							
								foreach(categories() as $category)
									echo '<option value="'.$category['id'].'">'.$category['name'].'</option>';
							
							?>
							
						</select>
						<hr>
						
						<button class="form-button" type="submit" name="run">
							اضافة
						</button>
						
					</form>
					
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
	</body>
</html>