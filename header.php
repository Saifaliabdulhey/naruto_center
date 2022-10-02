<!-- This is main configuration File --


<?php
include "config.php";
ob_start();
session_start();
include("admin/inc/config.php");
include("admin/inc/functions.php");
include("admin/inc/CSRF_Protect.php");
$csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';






// Getting all language variables into array as global variable
$i = 1;
$statement = $pdo->prepare("SELECT * FROM tbl_language");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	define('LANG_VALUE_' . $i, $row['lang_value']);
	$i++;
}

$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$logo = $row['logo'];
	$favicon = $row['favicon'];
	$contact_email = $row['contact_email'];
	$contact_phone = $row['contact_phone'];
	$meta_title_home = $row['meta_title_home'];
	$meta_keyword_home = $row['meta_keyword_home'];
	$meta_description_home = $row['meta_description_home'];
	$before_head = $row['before_head'];
	$after_body = $row['after_body'];
}

// Checking the order table and removing the pending transaction that are 24 hours+ old. Very important
$current_date_time = date('Y-m-d H:i:s');
$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ts1 = strtotime($row['payment_date']);
	$ts2 = strtotime($current_date_time);
	$diff = $ts2 - $ts1;
	$time = $diff / (3600);
	if ($time > 24) {

		// Return back the stock amount
		$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));
		$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result1 as $row1) {
			$statement2 = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
			$statement2->execute(array($row1['product_id']));
			$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result2 as $row2) {
				$p_qty = $row2['p_qty'];
			}
			$final = $p_qty + $row1['quantity'];

			$statement = $pdo->prepare("UPDATE tbl_product SET p_qty=? WHERE p_id=?");
			$statement->execute(array($final, $row1['product_id']));
		}

		// Deleting data from table
		$statement1 = $pdo->prepare("DELETE FROM tbl_order WHERE payment_id=?");
		$statement1->execute(array($row['payment_id']));

		$statement1 = $pdo->prepare("DELETE FROM tbl_payment WHERE id=?");
		$statement1->execute(array($row['id']));
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta Tags -->
<meta name="viewport" content="width=device-width,initial-scale=1.0" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

<!-- Favicon -->
<link rel="icon" type="image/png" href="assets/uploads/logo.png ?>">

<!-- Stylesheets -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
<link rel="stylesheet" href="assets/css/jquery.bxslider.min.css">
<link rel="stylesheet" href="assets/css/magnific-popup.css">
<link rel="stylesheet" href="assets/css/rating.css">
<link rel="stylesheet" href="assets/css/spacing.css">
<link rel="stylesheet" href="assets/css/bootstrap-touch-slider.css">
<link rel="stylesheet" href="assets/css/animate.min.css">
<link rel="stylesheet" href="assets/css/tree-menu.css">
<link rel="stylesheet" href="assets/css/select2.min.css">
<link rel="stylesheet" href="assets/css/main.css">
<link rel="stylesheet" href="assets/css/responsive.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<?php

$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$about_meta_title = $row['about_meta_title'];
	$about_meta_keyword = $row['about_meta_keyword'];
	$about_meta_description = $row['about_meta_description'];
	$faq_meta_title = $row['faq_meta_title'];
	$faq_meta_keyword = $row['faq_meta_keyword'];
	$faq_meta_description = $row['faq_meta_description'];
	$blog_meta_title = $row['blog_meta_title'];
	$blog_meta_keyword = $row['blog_meta_keyword'];
	$blog_meta_description = $row['blog_meta_description'];
	$contact_meta_title = $row['contact_meta_title'];
	$contact_meta_keyword = $row['contact_meta_keyword'];
	$contact_meta_description = $row['contact_meta_description'];
	$pgallery_meta_title = $row['pgallery_meta_title'];
	$pgallery_meta_keyword = $row['pgallery_meta_keyword'];
	$pgallery_meta_description = $row['pgallery_meta_description'];
	$vgallery_meta_title = $row['vgallery_meta_title'];
	$vgallery_meta_keyword = $row['vgallery_meta_keyword'];
	$vgallery_meta_description = $row['vgallery_meta_description'];
}

$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

if ($cur_page == 'index.php' || $cur_page == 'login.php' || $cur_page == 'registration.php' || $cur_page == 'cart.php' || $cur_page == 'checkout.php' || $cur_page == 'forget-password.php' || $cur_page == 'reset-password.php' || $cur_page == 'product-category.php' || $cur_page == 'product.php') {
?>
	<title><?php echo $meta_title_home; ?></title>
	<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
	<meta name="description" content="<?php echo $meta_description_home; ?>">
<?php
}

if ($cur_page == 'about.php') {
?>
	<title><?php echo $about_meta_title; ?></title>
	<meta name="keywords" content="<?php echo $about_meta_keyword; ?>">
	<meta name="description" content="<?php echo $about_meta_description; ?>">
<?php
}
if ($cur_page == 'faq.php') {
?>
	<title><?php echo $faq_meta_title; ?></title>
	<meta name="keywords" content="<?php echo $faq_meta_keyword; ?>">
	<meta name="description" content="<?php echo $faq_meta_description; ?>">
<?php
}
if ($cur_page == 'contact.php') {
?>
	<title><?php echo $contact_meta_title; ?></title>
	<meta name="keywords" content="<?php echo $contact_meta_keyword; ?>">
	<meta name="description" content="<?php echo $contact_meta_description; ?>">
<?php
}
if ($cur_page == 'product.php') {
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach ($result as $row) {
		$og_photo = $row['p_featured_photo'];
		$og_title = $row['p_name'];
		$og_slug = 'product.php?id=' . $_REQUEST['id'];
		$og_description = substr(strip_tags($row['p_description']), 0, 200) . '...';
	}
}

if ($cur_page == 'dashboard.php') {
?>
	<title>Dashboard - <?php echo $meta_title_home; ?></title>
	<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
	<meta name="description" content="<?php echo $meta_description_home; ?>">
<?php
}
if ($cur_page == 'customer-profile-update.php') {
?>
	<title>Update Profile - <?php echo $meta_title_home; ?></title>
	<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
	<meta name="description" content="<?php echo $meta_description_home; ?>">
<?php
}
if ($cur_page == 'customer-billing-shipping-update.php') {
?>
	<title>Update Billing and Shipping Info - <?php echo $meta_title_home; ?></title>
	<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
	<meta name="description" content="<?php echo $meta_description_home; ?>">
<?php
}
if ($cur_page == 'customer-password-update.php') {
?>
	<title>Update Password - <?php echo $meta_title_home; ?></title>
	<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
	<meta name="description" content="<?php echo $meta_description_home; ?>">
<?php
}
if ($cur_page == 'customer-order.php') {
?>
	<title>Orders - <?php echo $meta_title_home; ?></title>
	<meta name="keywords" content="<?php echo $meta_keyword_home; ?>">
	<meta name="description" content="<?php echo $meta_description_home; ?>">
<?php
}
?>

<?php if ($cur_page == 'blog-single.php') : ?>
	<meta property="og:title" content="<?php echo $og_title; ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo BASE_URL . $og_slug; ?>">
	<meta property="og:description" content="<?php echo $og_description; ?>">
	<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
<?php endif; ?>

<?php if ($cur_page == 'product.php') : ?>
	<meta property="og:title" content="<?php echo $og_title; ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo BASE_URL . $og_slug; ?>">
	<meta property="og:description" content="<?php echo $og_description; ?>">
	<meta property="og:image" content="assets/uploads/<?php echo $og_photo; ?>">
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://apps.elfsight.com/p/platform.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<div class="elfsight-app-1af5dc52-d481-4d16-9634-d7a785a43355"></div>

<script type="text/javascript">
	function getStates(value) {
		$.post("mypage.php", {
			partialState: value
		}, function(data) {
			$('#results').css({
				'display': 'block'});
			$("#results").html(data);
		});
	}
</script>
<script type="text/javascript" src="//platform-api.sharethis.com/js/sharethis.js#property=5993ef01e2587a001253a261&product=inline-share-buttons"></script>

<?php echo $before_head; ?>


<style>
	.header-container {
		display: flex;
		width: 100%;
		align-items: center;
		justify-content: space-between;
	}

	.customer_info {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-top: 50px;
	}

	.logo_pic {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-left: 250px;
		margin-top: 30px;
	}

	.search_rep {
		display: flex;
		justify-content: center;
		align-items: center;
		margin-top: 42px;
		width: 500px;
		margin-left: -50px;
	}



	.logo_pic_hub {
		width: 110px;
		margin-right: 10px;
		animation: spinner 6s linear infinite;
	}

	.icon {
		margin: 10px;
		list-style: none;
	}



	.search_input {
		padding: 5px 10px;
		width: 100% !important;
		background: #fff;
		box-shadow: 0px 0px 1px 1px #fff;
		margin: 0px;
		outline: none;
		color: black;
		border-top-left-radius: 30px;
		border-bottom-left-radius: 30px;
		border: none;
		margin-left: 80px;
		
	}

	.button_search {
		padding: 0px 5px;
		color: white;
		background: none;
		border: 1px solid white;
		border-top-right-radius: 30px;
		border-bottom-right-radius: 30px;
		border-left: none;
	}

	.search_icon {
		width: 30px;
		filter: invert(120%);
		color: white;
	}

	.multi-lang {
		margin-top: 42px;
		margin-right: 10px;
		color: white;
	}

	@keyframes spinner {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	@media only screen and (max-width: 1230px) {

		.search_rep {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 42px;
			width: 100% !important;
			margin-left: 10px;
			margin-right: 20px;
		}

		.search_input {
		padding: 5px 10px;
		width: 100% !important;
		background: #fff;
		box-shadow: 0px 0px 1px 1px #fff;
		margin: 0px;
		outline: none;
		color: black;
		border-top-left-radius: 30px;
		border-bottom-left-radius: 30px;
		border: none;
		margin-left: 10px;
		
	}

	.logo_title {
		display: none;
	}

	}
	@media only screen and (max-width: 1550px) {
		.logo_pic {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-left: 50px;
			margin-top: 30px;
		}

		.search_rep {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 42px;
			width: 100% !important;
			margin-left: 0px;
		}

	}

	@media only screen and (max-width: 920px) {
		.logo_pic_hub {
			width: 80px
		}

		.header-container {
			display: flex;
			width: 100%;
			align-items: center;
			justify-content: space-around;
			flex-wrap: wrap;
		}

		.icon {
			margin: 8px;
			margin-top:-20px;
			list-style: none;
		}

		.logo_pic {
			width: 300px;
			margin-left: 0px;
		}

		.logo_pic_hub {
			width: 100px
		}

		.logo_title {
			font-size: 27px;
		}

		.search_rep {
			display: flex;
			justify-content: center;
			align-items: center;
			margin-top: 30px !important;
			margin-left: 0px;
			width: 400px;
			margin: 10px;
		}

		.multi-lang {
			margin-top: 10px;
			margin-right: 0px;
			color: white;
		}

		.button_search {
		padding: 0px 5px;
		color: white;
		background: none;
		border: 1px solid white;
		border-top-right-radius: 30px;
		border-bottom-right-radius: 30px;
		border-left: none;
		margin-right: 30px;
	}


	}

	#results {
		display: none;
		z-index: 10000;
		position:absolute;
		width: 420px;
		backdrop-filter: blur(20px);
		background-color:rgba(42, 0, 100, 0.516);
		border-radius: 10px;
		top:80px;
		left:30px;
		height:auto;
		max-height:900px;
		overflow-y: scroll;
	}
</style>


<script>

</script>


</head>

<body>
	<!-- <div id="google_translate_element"></div>

	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'en'
			}, 'google_translate_element');
		}
	</script>

	<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script> -->

	<?php echo $after_body; ?>
	<!--
<div id="preloader">
	<div id="status"></div>
</div>-->

	<!-- top bar -->
	<div class="top">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="left">
						<ul>
							<li><i class="fa fa-phone"></i> <?php echo $contact_phone; ?></li>
							<li><i class="fa fa-envelope-o"></i> <?php echo $contact_email; ?></li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12">
					<div class="right">
						<ul>
							<?php
							$statement = $pdo->prepare("SELECT * FROM tbl_social");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach ($result as $row) {
							?>
								<?php if ($row['social_url'] != '') : ?>
									<li><a href="<?php echo $row['social_url']; ?>"><i class="<?php echo $row['social_icon']; ?>"></i></a></li>
								<?php endif; ?>
							<?php
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<!-- <input type="text" onkeyup="getStates(this.value)">
			<br> -->
			
		</div>
	</div>

	<div class="header" style="background: #C33764; /* fallback for old browsers */
         background: -webkit-linear-gradient(to right, #1D2671, #C33764);  /* Chrome 10-25, Safari 5.1-6 */
         background: linear-gradient(to right, #1D2671, #C33764); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
       ">
		<div class="">
			<div class="header-container">
				<div class="logo_pic">
					<a href="index.php"><img class="logo_pic_hub" src="assets/uploads/logo.png" alt="logo image"></a>
					<h1 class="logo_title" style="color:white;">Naruto
						<span>Center</span>
					</h1>
				</div>

			
				<div class="" style="display: flex; width:500px; position:relative; flex-direction:column;">
					<form style="width:100%;" style="width:100%" role="search" action="search-result.php" method="get">
						<?php $csrf->echoInputField(); ?>
						<div class=" search_rep">
							<input type="text" style="width:300px; display:flex;" autocomplete="off" class="search_input" onkeyup="getStates(this.value)" placeholder="<?php if ($_SESSION['lang'] == 'en') {
																														echo 'Search Product';
																													} else if ($_SESSION['lang'] == 'ar') {
																														echo 'ابحث عن منتج';
																													} ?>" name="search_text">
							<button type="submit" class="button_search"><img class="search_icon" src="./assets/img/search.png"></button>
						</div>
					</form>
					<div id="results"></div>
				</div>
				<div class="">
					<ul class="customer_info">

						<?php
						if (isset($_SESSION['customer'])) {
						?>
							<li class="icon" style='color: white;'><i style='color: white; direction: rtl;' class="fa fa-user"></i style='color: white; direction: rtl;'> <?php echo $_SESSION['customer']['cust_name']; ?></li>
							<li class="icon"><a style='color: white;' href="dashboard.php"><i class="fa fa-home"></i> <?php if ($_SESSION['lang'] == 'en') {
																															echo 'Settings';
																														} else if ($_SESSION['lang'] == 'ar') {
																															echo 'الاعدادات';
																														} ?></a></li>
						<?php
						} else {
						?>
							<li class="icon" style='color: white;'><a style='color: white;' href="login.php"><i class="fa fa-sign-in"></i> <?php if ($_SESSION['lang'] == 'en') {
																																				echo 'Login';
																																			} else if ($_SESSION['lang'] == 'ar') {
																																				echo 'تسجيل الدخول';
																																			} ?></a></li>
							<li class="icon"><a style='color: white;' href="registration.php"><i class="fa fa-user-plus"></i> <?php if ($_SESSION['lang'] == 'en') {
																																	echo 'Register';
																																} else if ($_SESSION['lang'] == 'ar') {
																																	echo 'التسجيل';
																																} ?></a></li>
						<?php
						}
						?>

						<li class="icon"><a style='color: white;' href="cart.php"><i class="fa fa-shopping-cart"></i> <?php if ($_SESSION['lang'] == 'en') {
																															echo 'Cart';
																														} else if ($_SESSION['lang'] == 'ar') {
																															echo 'السلة';
																														} ?> (<?php echo LANG_VALUE_1; ?><?php
																																							if (isset($_SESSION['cart_p_id'])) {
																																								$table_total_price = 0;
																																								$i = 0;
																																								foreach ($_SESSION['cart_p_qty'] as $key => $value) {
																																									$i++;
																																									$arr_cart_p_qty[$i] = $value;
																																								}
																																								$i = 0;
																																								foreach ($_SESSION['cart_p_current_price'] as $key => $value) {
																																									$i++;
																																									$arr_cart_p_current_price[$i] = $value;
																																								}
																																								for ($i = 1; $i <= count($arr_cart_p_qty); $i++) {
																																									$row_total_price = $arr_cart_p_current_price[$i] * $arr_cart_p_qty[$i];
																																									$table_total_price = $table_total_price + $row_total_price;
																																								}
																																								echo $table_total_price;
																																							} else {
																																								echo '0.00';
																																							}
																																							?>)</a></li>
					</ul>
				</div>
				<div class="multi-lang">
					<form method='post' style="display: flex;">
						<input style="margin-right: 5px; padding: 2px 10px; color:white; border-radius:5px; background:transparent; border:1px solid; font-weight: 500;" type="submit" id="btnSubmit" name="btnSubmit" value="عربي" />
						<input style="margin-right: 5px; padding: 2px 6px; color:white; border-radius:5px; background:transparent; border:1px solid;" type="submit" id="btnDelete" name="btnDelete" value="English" />
						<?php echo $_SESSION['lang'] ?>
					</form>
				</div>
			</div>

		</div>
	</div>

	<div style="background: #C33764;  /* fallback for old browsers */
           background: -webkit-linear-gradient(to right, #1D2671, #C33764);  /* Chrome 10-25, Safari 5.1-6 */
           background: linear-gradient(to right, #1D2671, #C33764); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
" class="nav">
		<div class="container">
			<div class="row">
				<div class="col-md-12 pl_0 pr_0">
					<div class="menu-container" style="background-color: rgba(255, 0, 0, 0)">
						<div class="menu">
							<ul>

								<li><a style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" id=" home" href="index.php"><?php if ($_SESSION['lang'] == 'ar') {
																																								echo 'الصفحة الرئيسية';
																																							} else if ($_SESSION['lang'] == 'en') {
																																								echo 'Home';
																																							} ?></a></li>


								<?php

								if (isset($_POST["btnSubmit"])) {
									echo 'Arabic';
									$_SESSION['lang'] = 'ar';
									header("Refresh:0; url=index.php");
								} else if (isset($_POST["btnDelete"])) {
									// "Delete" clicked
									$_SESSION['lang'] = 'en';
									echo 'English';
									header("Refresh:0; url=index.php");
								}

								if ($_SESSION['lang'] == "ar") {
									$statement =  $pdo->prepare("SELECT * FROM tbl_top_arabic WHERE show_on_menu=1");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								} else if ($_SESSION['lang'] == "en" || $_SESSION['lang'] == "") {
									$statement =  $pdo->prepare("SELECT * FROM tbl_top_category WHERE show_on_menu=1");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								}

								foreach ($result as $row) {
								?>
									<li><a style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" href="product-category.php?id=<?php echo $row['tcat_id']; ?>&type=top-category"><?php echo $row['tcat_name']; ?></a>
										<ul>
											<?php
											if ($_SESSION['lang'] == "en") {
												$statement1 = $pdo->prepare("SELECT * FROM tbl_mid_category WHERE tcat_id=?");
												$statement1->execute(array($row['tcat_id']));
												$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											} else if ($_SESSION['lang'] == "ar") {
												$statement1 = $pdo->prepare("SELECT * FROM tbl_mid_arabic_category WHERE tcat_id=?");
												$statement1->execute(array($row['tcat_id']));
												$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
											}
											foreach ($result1 as $row1) {
											?>
												<li style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;"><a href="product-category.php?id=<?php echo $row1['mcat_id']; ?>&type=mid-category"><?php echo $row1['mcat_name']; ?></a>
													<ul>
														<?php
														$statement2 = $pdo->prepare("SELECT * FROM tbl_end_category WHERE mcat_id=?");
														$statement2->execute(array($row1['mcat_id']));
														$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
														foreach ($result2 as $row2) {
														?>
															<li><a href="product-category.php?id=<?php echo $row2['ecat_id']; ?>&type=end-category"><?php echo $row2['ecat_name']; ?></a></li>
														<?php
														}
														?>
													</ul>
												</li>
											<?php
											}
											?>
										</ul>
									</li>
								<?php
								}

								?>

								<?php
								$statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
								$statement->execute();
								$result = $statement->fetchAll(PDO::FETCH_ASSOC);
								foreach ($result as $row) {
									$about_title = $row['about_title'];
									$faq_title = $row['faq_title'];
									$blog_title = $row['blog_title'];
									$contact_title = $row['contact_title'];
									$pgallery_title = $row['pgallery_title'];
									$vgallery_title = $row['vgallery_title'];
								}
								?>

								<li><a style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" href="about.php"><?php if ($_SESSION['lang'] == 'en') {
																																					echo 'About Us';
																																				} else if ($_SESSION['lang'] == 'ar') {
																																					echo 'حول ناروتو ';
																																				} ?></a></li>
								<li><a style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" href="faq.php"><?php if ($_SESSION['lang'] == 'en') {
																																				echo 'FAQ';
																																			} else if ($_SESSION['lang'] == 'ar') {
																																				echo 'التعليمات';
																																			} ?></a></li>

								<li><a style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-weight:700;" href="contact.php"><?php if ($_SESSION['lang'] == 'en') {
																																					echo 'Contact Us';
																																				} else if ($_SESSION['lang'] == 'ar') {
																																					echo 'تواصل معنا';
																																				} ?></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>