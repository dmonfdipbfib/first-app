<nav class="navbar navbar-expand-lg navbar-dark justify-content-between fixed-top">

	<a class="navbar-brand animated fadeInLeft">
		<?php echo SYSTEM_NAME ?>
	</a>
	
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto animated fadeInRight">
			<li class="nav-item">
				<a class="nav-link" href="./">البيانات الشخصية</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="new-admin.php">اضافة مدير</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="admins.php">قائمة المديرين</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="new-category.php">اضافة قسم </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="categories.php">الاقسام </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="companies.php">  المستشفيات </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="customers.php">  العملاء </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="new-companies.php"> (<?php echo count(wait4access()) ?>) المستشفيات الجديدة </a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="complaints.php">الشكاوى</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="out.php">خروج</a>
			</li>
		</ul>
	</div>
</nav>