<?php
/**
 * Sample layout
 */

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;
use Helpers\AccessHelper;

$ah = new AccessHelper();
$ah->refreshPermissions();


//initialise hooks
$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>

	<!-- Site meta -->
	<meta charset="utf-8">
	<?php
	//hook for plugging in meta tags
	$hooks->run('meta');
	?>
	<title><?php echo $data['title'].' - '.SITETITLE; //SITETITLE defined in app/Core/Config.php ?></title>

	<!-- CSS -->
	<?php
	Assets::css(array(
		Url::templatePath() . 'css/bootstrap.min.css',
		Url::templatePath() . 'css/jquery-ui.min.css',
		Url::templatePath() . 'css/jquery-ui.theme.css',
		Url::templatePath() . 'css/style.css'
	));
	
	//hook for plugging in css
	$hooks->run('css');
	?>

</head>
<body>
<div class="container-fluid header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<img class="logo" src="<?php echo Url::templatePath(); ?>/images/logo.jpg" />
				<ul class="header-nav">
					<?php
					if(AccessHelper::checkAccess("food", 1, 0)) {
						?>
						<li><a href="/food-products">Food Products</a></li>
						<?php
					}
					if(AccessHelper::checkAccess("employees", 1, 0)) {
						?>
						<li><a href="/employees">Employees</a></li>
						<?php
					}
					if(AccessHelper::checkAccess("healthsafety", 1, 0)) {
						?>
						<li><a href="/health-and-safety">Health &amp; Safety</a></li>
						<?php
					}
					if(AccessHelper::checkAccess("operatingprocedures", 1, 0)) {
						?>
						<li><a href="/operating-procedures">Operating Procedures</a></li>
						<?php
					}
					if(AccessHelper::is_admin()) {
						?>
						<li><a href="/users">Users</a></li>
						<?php
					}
					?>
					<li><span>Logged in as <?php echo $_SESSION['user']['user_username']; ?></span><a href="/users/logout">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php
//hook for running code after body tag
$hooks->run('afterBody');
?>

<div class="container">
<div class="row">
<div class="col-md-12">
	<?php
	
	use Models\PageAccessModel;
	$pam = new PageAccessModel();
	
	use Helpers\NotificationHelper;
	$nh = new NotificationHelper;
	$nh->display();
	?>