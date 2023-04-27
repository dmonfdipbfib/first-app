<?php

ob_start();

require_once('variables.php');

$server_message = "";
$database_connection = null;
$server_data = [];

function connect(){
	
	global $server_message, $database_connection;
	
	$con = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASE);
	
	if(!$con){
		$server_message = 'لا يمكن الوصول لقاعدة البيانات';
		return false;
	}
	
	mysqli_set_charset($con,"utf8");
	
	$database_connection = $con;
	
	return true;
	
}

function execute($sql, $close = true){

	global $server_message, $database_connection;
	
	if(!connect()) return false;
	
	$query = mysqli_query($database_connection, $sql);
	
	if(!$query){
		$server_message = 'خطأ فى تنفيذ الاستعلام على قاعدة البيانات <br> '. mysqli_error($database_connection);
		return false;
	}
	
	if($close) mysqli_close($database_connection);
	
	return $query;
	
}

function login($email, $password){
	
	global $server_message;
	
	$sql = "SELECT `id` FROM `admin` WHERE `email` = '{$email}' AND `password` = '{$password}'";
	
	$execute = execute($sql);
	
	if(mysqli_num_rows($execute) == 1){
		$id = mysqli_fetch_array($execute)['id'];
		setcookie('admin', $id, time() + (60 * 60 * 24 * 30), '/');
		return true;
	}
	
	$sql = "SELECT `id` FROM `company` WHERE `email` = '{$email}' AND `password` = '{$password}'";
	
	$execute = execute($sql);
	
	if(mysqli_num_rows($execute) == 1){
		$id = mysqli_fetch_array($execute)['id'];
		setcookie('company', $id, time() + (60 * 60 * 24 * 30), '/');
		return true;
	}
	
	$sql = "SELECT `id` FROM `customer` WHERE `email` = '{$email}' AND `password` = '{$password}'";
	
	$execute = execute($sql);
	
	if(mysqli_num_rows($execute) == 1){
		$id = mysqli_fetch_array($execute)['id'];
		setcookie('customer', $id, time() + (60 * 60 * 24 * 30), '/');
		return true;
	}
	
	$server_message = "المستخدم غير مسجل" . "<br>" . "<a href='android.php' class='white-link'>إنشاء حساب</a>";
	return false;
	
}

function admin_create($name, $email, $password, $confirm){
	
	global $server_message;
	
	if(empty($name) || empty($email) || empty($password)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if($password != $confirm){
		$server_message = "كلمة السر لا تطابق تاكيد كلمة السر";
		return false;
	}
	
	$sql = "(SELECT `email` FROM `admin` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `company` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `customer` WHERE `email` = '{$email}')";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "البريد الالكترونى مسجل مسبقا";
		return false;
	}
	
	$sql = "INSERT INTO `admin`(`name`, `email`, `password`) VALUES ('{$name}','{$email}','{$password}')";
	
	return execute($sql) !== false;
	
}

function company_create($name, $email, $file, $password, $confirm){
	
	global $server_message, $database_connection;
	
	if(empty($name) || empty($email) || empty($file['tmp_name']) || empty($password)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if($password != $confirm){
		$server_message = "كلمة السر لا تطابق تاكيد كلمة السر";
		return false;
	}
	
	$sql = "(SELECT `email` FROM `admin` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `company` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `customer` WHERE `email` = '{$email}')";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "البريد الالكترونى مسجل مسبقا";
		return false;
	}
	
	if(!is_file($file['tmp_name']) || !in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpeg', 'jpg'])){
		$server_message = "الملف غير صحيح";
		return false;
	}
	
	$location = $file['name'];
	
	if(file_exists('images/'. $file['name'])) $location = uniqid() . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

	$sql = "INSERT INTO `company`(`name`, `logo`, `email`, `password`) VALUES ('{$name}','{$location}','{$email}','{$password}')";
	
	if(!execute($sql, false)) return false;
	
	move_uploaded_file($file['tmp_name'], 'images/'. $location);
	
	$id = mysqli_insert_id($database_connection);
	
	mysqli_close($database_connection);
	
	setcookie('company', $id, time() + (60 * 60 * 24 * 30), '/');
	
	return true;
	
}

function customer_create($name, $email, $password, $confirm){
	
	global $server_message, $database_connection;
	
	if(empty($name) || empty($email) || empty($password)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if($password != $confirm){
		$server_message = "كلمة السر لا تطابق تاكيد كلمة السر";
		return false;
	}
	
	$sql = "(SELECT `email` FROM `admin` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `company` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `customer` WHERE `email` = '{$email}')";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "البريد الالكترونى مسجل مسبقا";
		return false;
	}
	
	$sql = "INSERT INTO `customer`(`name`, `email`, `password`) VALUES ('{$name}','{$email}','{$password}')";
	
	$execute = execute($sql, false);
	
	if(!$execute) return false;
	
	$id = mysqli_insert_id($database_connection);
	
	mysqli_close($database_connection);
	
	setcookie('customer', $id, time() + (60 * 60 * 24 * 30), '/');
	
	return true;
	
}

function new_category($name, $file, $admin){
	
	global $server_message;
	
	if(empty($name)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!admin($admin)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	$sql = "SELECT `name` FROM `category` WHERE `name` = '{$name}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "الاسم مسجل مسبقا";
		return false;
	}
	
	if(!is_file($file['tmp_name']) || !in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpeg', 'jpg'])){
		$server_message = "الملف غير صحيح";
		return false;
	}
	
	$location = $file['name'];
	
	if(file_exists('../images/'. $file['name'])) $location = uniqid() . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

	$sql = "INSERT INTO `category`(`name`, `photo`, `admin_id`) VALUES ('{$name}','{$location}','{$admin}')";
	
	move_uploaded_file($file['tmp_name'], '../images/'. $location);
	
	return execute($sql) !== false;
	
}

function category_update($name, $file, $id){
	
	global $server_message, $server_data;
	
	if(empty($name)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!category($id)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	$oldImage = $server_data['logo'];
	
	$sql = "SELECT `name` FROM `category` WHERE `name` = '{$name}' AND `id` <> '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "الاسم مسجل مسبقا";
		return false;
	}
	
	if(isset($file['tmp_name']) && !empty($file['tmp_name'])){
			
		if(!is_file($file['tmp_name']) || !in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpeg', 'jpg'])){
			$server_message = "الملف غير صحيح";
			return false;
		}
		
		$location = $file['name'];
		
		if(file_exists('../images/'. $file['name'])) $location = uniqid() . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

		$sql = "UPDATE `category` SET `photo` = '{$location}'";
	
		move_uploaded_file($file['tmp_name'], '../images/'. $location);
	
		@unlink('images/'. $location);
	
	}
	
	$sql = "INSERT INTO `category`(`name`) VALUES ('{$name}')";
	
	return execute($sql) !== false;
	
}

function new_product($name, $price, $file, $details, $company, $category){
	
	global $server_message;
	
	if(empty($name) || empty($details) || !is_float($price) && !is_numeric($price)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!company($company)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!category($category)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!is_file($file['tmp_name']) || !in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpeg', 'jpg'])){
		$server_message = "الملف غير صحيح";
		return false;
	}
	
	$location = $file['name'];
	
	if(file_exists('../images/'. $file['name'])) $location = uniqid() . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

	$sql = "INSERT INTO `product`(`name`, `image`, `price`, `details`, `company_id`, `category_id`)
				VALUES ('{$name}','{$location}','{$price}','{$details}','{$company}','{$category}')";
	
	move_uploaded_file($file['tmp_name'], '../images/'. $location);
	
	return execute($sql) !== false;
	
}

function new_offer($discount, $product_id, $status = 0, $start_date = null, $end_date = null){
	
	global $server_message, $server_data;
	
	if(!is_numeric($discount) && !is_float($discount) || $discount < 1){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!product($product_id)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if($status){
		if($discount > 99){
			$server_message = "من فضلك ادخل البيانات المطلوبة";
			return false;
		}
	}else{
		if($server_data['price'] <= $discount){
			$server_message = "من فضلك ادخل البيانات المطلوبة";
			return false;
		}
	}
	

	if(!validateDate($start_date) || !validateDate($end_date)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(strtotime($start_date) > strtotime($end_date)){
		$server_message = "تاريخ البداية اكبر من تاريخ النهاية";
		return false;
	}
	
	if(strtotime($start_date) < strtotime('-1 day', time())){
		$server_message = "تاريخ البداية قبل تاريخ اليوم";
		return false;
	}
	
	$sql = "SELECT * FROM `offer` WHERE `product_id` = '{$product_id}' AND `start_date` >= DATE('{$start_date}') AND `end_date` <= DATE('{$end_date}')";

	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "هناك عرض اخر مسجل فى ذلك الوقت لنفس المنتج";
		return false;
	}
	
	$status = $status ? 1 : 0;
	
	$sql = "INSERT INTO `offer`(`discount`, `start_date`, `end_date`, `status`, `product_id`)
				VALUES ('{$discount}','{$start_date}','{$end_date}','{$status}','{$product_id}')";
	
	return execute($sql) !== false;
	
}

function get_product_offers($product_id){
	
	global $server_data;
	
	if(!product($product_id)) return [];
	
	$sql = "SELECT * FROM `offer` WHERE `product_id` = '{$product_id}' AND `start_date` >= CURDATE() ORDER BY `start_date` ASC";
	
	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function get_product_today_offer($product_id){
	
	global $server_data;
	
	if(!product($product_id)) return [];
	
	$sql = "SELECT * FROM `offer` WHERE `product_id` = '{$product_id}' AND `start_date` <= CURDATE() AND `end_date` >= CURDATE() ORDER BY `start_date` ASC";
	
	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	return mysqli_fetch_array($execute);
	
}

function today_offers(){
	
	global $server_data;
	
	$sql = "SELECT * FROM `offer` WHERE `start_date` <= CURDATE() AND `end_date` >= CURDATE() ORDER BY `start_date` ASC";
	
	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function product_update($name, $price, $file, $details, $category, $id){
	
	global $server_message, $server_data;
	
	if(empty($name) || empty($details) || !is_float($price) && !is_numeric($price)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!product($id)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!category($category)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	$oldImage = $server_data['logo'];
	
	if(isset($file['tmp_name']) && !empty($file['tmp_name'])){
			
		if(!is_file($file['tmp_name']) || !in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpeg', 'jpg'])){
			$server_message = "الملف غير صحيح";
			return false;
		}
		
		$location = $file['name'];
		
		if(file_exists('../images/'. $file['name'])) $location = uniqid() . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

		$sql = "UPDATE `product` SET `image` = '{$location}'";
	
		move_uploaded_file($file['tmp_name'], '../images/'. $location);
	
		@unlink('images/'. $location);
	
	}
	
	$sql = "INSERT INTO `product`(`name`, `price`, `details`, `category_id`) VALUES ('{$name}','{$price}','{$details}','{$category}')";
	
	return execute($sql) !== false;
	
}

function new_order($quantity, $price, $customer_id, $product_id,$Notes){
	
	global $server_message;
	
	if(!is_numeric($quantity) || !is_numeric($price) && !is_float($price)){
		$server_message = "من فضلك ادخل بيانات صحيحة";
		return false;
	}
	
	if(!product($product_id)){
		$server_message = "من فضلك ادخل بيانات صحيحة";
		return false;
	}
	
	if(!customer($customer_id)){
		$server_message = "من فضلك ادخل بيانات صحيحة";
		return false;
	}
	
	$sql = "SELECT * FROM `p_order` WHERE `customer_id` = '{$customer_id}' AND `product_id` = '{$product_id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "الطلب مسجل مسبقا";
		return false;
	}
	
	$sql = "INSERT INTO `p_order`(`quantity`, `price`, `customer_id`, `product_id`, `Notes`) VALUES ('{$quantity}','{$price}','{$customer_id}','{$product_id}','{$Notes}')";
	
	return execute($sql) !== false;
	
}
function approve($id){

	global $server_message;

	
	$sql = "UPDATE `p_order` SET `Confirmed`=1 WHERE `id` = '{$id}'";
	
	return execute($sql) !== false;
}
function order($id){
	
	global $server_data;
	
	
	
	$sql = "SELECT * FROM `p_order` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}
function myorder($cust,$prod){
	
	global $server_data;
	
	
	
	$sql = "SELECT * FROM `p_order` WHERE `product_id` = '{$prod}' AND `customer_id` = '{$cust}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}
function orders($customer = 0){
	
	if($$customer = 0) $sql = "SELECT * FROM `p_order` WHERE `customer_id` = '{$customer}'";
	else $sql = "SELECT * FROM `p_order`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function orders4companies($company){
	
	$sql = "SELECT * FROM `p_order` WHERE `product_id` IN (SELECT `id` FROM `product` WHERE `company_id` = '{$company}')";
	
	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function orders4customer($customer){
	
	$sql = "SELECT * FROM `p_order` WHERE `customer_id` = '{$customer}'";
	
	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function ordered($product, $customer){
	
	global $server_data;
	
	$sql = "SELECT * FROM `p_order` WHERE `product_id` = '{$product}' AND `customer_id` = '{$customer}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(!mysqli_num_rows($execute)) return false;
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function add_complaint($subject,$details,$customer){
	
	global $server_message;
	
	if(empty($subject) || empty($details)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!customer($customer)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	$sql = "INSERT INTO `complaint`(`subject`, `details`, `customer_id`) VALUES ('{$subject}','{$details}','{$customer}')";
	
	return execute($sql) !== false;
	
}

function complaints($search = null){
	
	if(!empty($search)) $sql = "SELECT * FROM `complaint` WHERE `subject` LIKE '%{$search}%'";
	else $sql = "SELECT * FROM `complaint`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function complaint($id){
	
	global $server_data;
	
	$sql = "SELECT * FROM `complaint` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function admin_get(){
	
	global $database_connection, $server_data;
	
	if(!isset($_COOKIE['admin'])) return false;
	
	$id = $_COOKIE['admin'];
	
	$sql = "SELECT * FROM `admin` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		logout();
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function admins($search = null){
	
	if(!empty($search)) $sql = "SELECT * FROM `admin` WHERE `name` LIKE '%{$search}%' OR `email` LIKE '%{$search}%'";
	else $sql = "SELECT * FROM `admin`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function admin($id){
	
	global $server_data;
	
	$sql = "SELECT * FROM `admin` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function category($id){
	
	global $server_data;
	
	$sql = "SELECT * FROM `category` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function categories($search = null){
	
	if(!empty($search)) $sql = "SELECT * FROM `category` WHERE `name` LIKE '%{$search}%'";
	else $sql = "SELECT * FROM `category`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function product($id){
	
	global $server_data;
	
	$sql = "SELECT * FROM `product` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function products($search = null){
	
	if(!empty($search)) $sql = "SELECT * FROM `product` WHERE `name` LIKE '%{$search}%'";
	else $sql = "SELECT * FROM `product`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function products4companies($company,$search = null){
	
	if(!company($company)) return [];
	
	if(!empty($search)) $sql = "SELECT * FROM `product` WHERE `name` LIKE '%{$search}%' AND `company_id` = '{$company}'";
	else $sql = "SELECT * FROM `product` WHERE `company_id` = '{$company}'";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function productsSearch($search = null, $category = 0){
	
	$where = false;
	$rule  = "";
	
	if(!empty($search)){
		$rule = "`name` LIKE '%{$search}%'";
		$where = true;
	}
	
	if(category($category)){
		$rule = $where ? $rule . "AND `category_id` = '{$category}'" : "`category_id` = '{$category}'";
		$where = true;
	}
	
	if($where) $sql = "SELECT * FROM `product` WHERE " . $rule;
	else $sql = "SELECT * FROM `product`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function company_get(){
	
	global $database_connection, $server_data;
	
	if(!isset($_COOKIE['company'])) return false;
	
	$id = $_COOKIE['company'];
	
	$sql = "SELECT * FROM `company` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		logout();
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function companies($search = null){
	
	if(!empty($search)) $sql = "SELECT * FROM `company` WHERE `name` LIKE '%{$search}%' OR `email` LIKE '%{$search}%'";
	else $sql = "SELECT * FROM `company`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function company($id){
	
	global $server_data;
	
	$sql = "SELECT * FROM `company` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function customer_get(){
	
	global $database_connection, $server_data;
	
	if(!isset($_COOKIE['customer'])) return false;
	
	$id = $_COOKIE['customer'];
	
	$sql = "SELECT * FROM `customer` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		logout();
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function customers($search = null){
	
	if(!empty($search)) $sql = "SELECT * FROM `customer` WHERE `name` LIKE '%{$search}%' OR `email` LIKE '%{$search}%'";
	else $sql = "SELECT * FROM `customer`";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function customer($id){
	
	global $server_data;
	
	$sql = "SELECT * FROM `customer` WHERE `id` = '{$id}'";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute) != 1){
		return false;
	}	
	
	$server_data = mysqli_fetch_array($execute);
	
	return true;
	
}

function wait4access(){
	
	$sql = "SELECT * FROM `company` WHERE `access` = '0'";

	$execute = execute($sql);
	
	if(!$execute) return [];
	
	if(!mysqli_num_rows($execute)) return [];
	
	$data = [];
	
	while($result = mysqli_fetch_array($execute)) $data[] = $result;
	
	return $data;
	
}

function setAccess($id){
	
	if(!company($id)) return false;
	
	$sql = "UPDATE `company` SET `access` = '1' WHERE `id` = '{$id}'";
	
	return execute($sql) !== false;
	
}

function update_admin($name, $email, $password, $confirm, $id){
	
	global $server_message;
	
	if(!admin($id)){
		$server_message = "غير مصرح بالدخول";
		return false;
	}
	
	if(empty($name) || empty($email)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!empty($password)){
		
		if($password != $confirm){
			$server_message = "كلمة السر لا تطابق تاكيد كلمة السر";
			return false;
		}
		
		$sql = "UPDATE `admin` SET `password` = '{$password}' WHERE `id` = '{$id}'";
		
		$execute = execute($sql);
		
		if(!$execute) return false;
		
	}
	
	$sql = "(SELECT `email` FROM `admin` WHERE `email` = '{$email}' AND `id` <> '{$id}') UNION" .
				" (SELECT `email` FROM `company` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `customer` WHERE `email` = '{$email}')";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "البريد الالكترونى مسجل مسبقا";
		return false;
	}
	
	$sql = "UPDATE `admin` SET `name` = '{$name}', `email` = '{$email}' WHERE `id` = '{$id}'";
	
	return execute($sql) !== false;
	
}

function update_company($name, $email, $file, $password, $confirm, $id){
	
	global $server_message, $server_data;
	
	if(!company($id)){
		$server_message = "غير مصرح بالدخول";
		return false;
	}
	
	$oldImage = $server_data['logo'];
	
	if(empty($name) || empty($email)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!empty($password)){
		
		if($password != $confirm){
			$server_message = "كلمة السر لا تطابق تاكيد كلمة السر";
			return false;
		}
		
		$sql = "UPDATE `company` SET `password` = '{$password}' WHERE `id` = '{$id}'";
		
		$execute = execute($sql);
		
		if(!$execute) return false;
		
	}
	
	if(isset($file['tmp_name']) && !empty($file['tmp_name'])){
		
		if(!is_file($file['tmp_name']) || !in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['png', 'jpeg', 'jpg'])){
			$server_message = "الملف غير صحيح";
			return false;
		}
		
		$location = $file['name'];
		
		if(file_exists('images/'. $file['name'])) $location = uniqid() . "." . pathinfo($file['name'], PATHINFO_EXTENSION);

		$sql = "UPDATE `company` SET `logo` = '{$location}'";
	
		$execute = execute($sql);
		
		if(!$execute) return false;
		
		move_uploaded_file($file['tmp_name'], '../images/'. $location);
	
		@unlink('../images/' . $oldImage);
	
	}
	
	$sql = "(SELECT `email` FROM `admin` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `company` WHERE `email` = '{$email}' AND `id` <> '{$id}') UNION" .
				" (SELECT `email` FROM `customer` WHERE `email` = '{$email}')";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "البريد الالكترونى مسجل مسبقا";
		return false;
	}
	
	$sql = "UPDATE `company` SET `name` = '{$name}', `email` = '{$email}' WHERE `id` = '{$id}'";
	
	return execute($sql) !== false;
	
}

function update_customer($name, $email, $password, $confirm, $id){
	
	global $server_message;
	
	if(!customer($id)){
		$server_message = "غير مصرح بالدخول";
		return false;
	}
	
	if(empty($name) || empty($email)){
		$server_message = "من فضلك ادخل البيانات المطلوبة";
		return false;
	}
	
	if(!empty($password)){
		
		if($password != $confirm){
			$server_message = "كلمة السر لا تطابق تاكيد كلمة السر";
			return false;
		}
		
		$sql = "UPDATE `customer` SET `password` = '{$password}' WHERE `id` = '{$id}'";
		
		$execute = execute($sql);
		
		if(!$execute) return false;
		
	}
	
	$sql = "(SELECT `email` FROM `admin` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `company` WHERE `email` = '{$email}') UNION" .
				" (SELECT `email` FROM `customer` WHERE `email` = '{$email}' AND `id` <> '{$id}')";
	
	$execute = execute($sql);
	
	if(!$execute) return false;
	
	if(mysqli_num_rows($execute)){
		$server_message = "البريد الالكترونى مسجل مسبقا";
		return false;
	}
	
	$sql = "UPDATE `customer` SET `name` = '{$name}', `email` = '{$email}' WHERE `id` = '{$id}'";
	
	return execute($sql) !== false;
	
}

function remove($table, $id){
	
	$sql = "DELETE FROM `{$table}` WHERE `id` = {$id}";
	
	return execute($sql) !== false;
	
}

function is_logged_in(){
	if(isset($_COOKIE['admin']) || isset($_COOKIE['company']) || isset($_COOKIE['customer'])) return true;
	return false;
}

function login_redirect(){
	if(isset($_COOKIE['admin'])) header('location: admin/');
	if(isset($_COOKIE['company'])) header('location: company/');
	if(isset($_COOKIE['customer'])) header('location: customer/');
}

function logout(){
	if(isset($_COOKIE['admin'])) setcookie('admin', '', time() - (60 * 60 * 24 * 30), '/');
	if(isset($_COOKIE['company'])) setcookie('company', '', time() - (60 * 60 * 24 * 30), '/');
	if(isset($_COOKIE['customer'])) setcookie('customer', '', time() - (60 * 60 * 24 * 30), '/');
}

function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}