
<?php

	require_once('../server.php');
	if(!company_get()) header('location: ../');
	
	$data = $server_data;
	
	if(isset($_GET['delete'])){
		remove('product', $_GET['delete']);
		header("location: products.php");
		return;
	}
	
	if(!isset($_GET['id'])){
		header('location: ./');
	}
	
	if(!product($_GET['id'])){
		header('location: ./');
	}
	
	$current = $server_data;
	
	if(isset($_GET['deleteOffer'])){
		remove('offer', $_GET['deleteOffer']);
		header("location: show-product.php?id=".$current['id']);
		return;
	}
	
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
				
				<a href="products.php" class="form-top-button">رجوع</a>
				
				<table class="table">
				
					<tr class="text-right">
						<td><?php echo $current['name'] ?></td>
						<td>الاسم</td>
					</tr>
				
					<tr class="text-right">
						<td><img src="../images/<?php echo $current['image'] ?>" class="global-image-size"/></td>
						<td>الصورة</td>
					</tr>
				
					<tr class="text-right">
						<td><?php echo $current['price'] ?></td>
						<td>سعر  الحضانة و الرعاية</td>
					</tr>
				
					<tr class="text-right">
						<td><?php echo $current['details'] ?></td>
						<td>التفاصيل</td>
					</tr>
				
					<tr class="text-right">
						<td><?php category($current['category_id']); echo $server_data['name'] ?></td>
						<td>القسم</td>
					</tr>
				
					<tr class="text-right">
						<td><button type="button" data-toggle="modal" data-target="#addOffer" class="btn btn-info">اضافة عرض</button></td>
						<td><button type="button" onClick="unlink('<?php echo $current['id'] ?>')" class="btn btn-danger">حذف</button></td>
					</tr>
				
				</table>
				
				<div class="form-title">
					العروض 
				</div>
		
				<div class="run-into">
				
					<?php
					
						if(isset($_POST['run'])){
							if(!new_offer($_POST['discount'], $current['id'], $_POST['status'], $_POST['start_date'], $_POST['end_date'])){
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
				
				<div class="table-responsive">
					<table class="table" id="offers">
						<tr>
							<td>العرض</td>
							<td>البداية</td>
							<td>النهاية</td>
							<td>حذف</td>
						</tr>
						
						<?php
						foreach(get_product_offers($current['id']) as $offer){
							$per = $offer['status'] ? "%" : " جنية ";
						?>
						
						<tr>
							<td><?php echo $offer['discount'] . $per; ?></td>
							<td><?php echo $offer['start_date']; ?></td>
							<td><?php echo $offer['end_date']; ?></td>
							<td>
								<button type="button" class="btn btn-danger" onClick="unlinkOffer('<?php echo $offer['id'] ?>')">X</button>
							</td>
						</tr>
						
						<?php
						}
						?>
						
					</table>
				</div>
			</div>
			
		</div>
		<div id="addOffer" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="login-box">
						<form method="post">
							<label>النوع</label>
							<select name="status" class="form-input">
								<option value="1">نسبة مئوية</option>
								<option value="0">مبلغ مالى</option>
							</select>
							<hr>
							<label>القيمة</label>
							<input type="text" class="form-input" name="discount">
							<hr>
							<label>تاريخ بداية العرض</label>
							<input type="text" class="form-input dates" name="start_date" value="<?php echo date('Y-m-d') ?>">
							<hr>
							<label>تاريخ نهاية العرض</label>
							<input type="text" class="form-input dates" name="end_date" value="<?php echo date('Y-m-d') ?>">
							<hr>
							<button class="form-button" type="submit" name="run">
								اضافة
							</button>
						</form>

					</div>
				</div>
			</div>
		</div>
		<!-- page code ends -->
		
		<!-- including javascript files -->
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.js"></script>
		<script src="../js/custom.js"></script>
		<script src="../js/bootstrap-datepicker.js"></script>
		
		<script>
			$('.dates').datepicker({
				format: 'yyyy-mm-dd'
			});

			function unlink(id){
				
				var conf = confirm("تاكيد الحذف");
				if(!conf) return;
				
				window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?delete="+id;
				
			}
			
			function unlinkOffer(id){
				
				var conf = confirm("تاكيد الحذف");
				if(!conf) return;
				
				window.location = "<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $current['id'] ?>&deleteOffer="+id;
				
			}
			
		</script>
		
	</body>
</html>