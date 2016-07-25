<?php
	
	namespace Helpers;
	
	use Core\View;
	use \Models\UsersModel;
	
	class AccessHelper {
		
		public function refreshPermissions() {
			
			$um = new \Models\UsersModel();
			
			$user_permissions = $um->getUserPermissions($_SESSION['user']['user_id']);
			
			$_SESSION['user']['user_food_access'] 					= $user_permissions->user_food_access;
			$_SESSION['user']['user_employees_access'] 				= $user_permissions->user_employees_access;
			$_SESSION['user']['user_healthsafety_access'] 			= $user_permissions->user_healthsafety_access;
			$_SESSION['user']['user_operatingprocedures_access'] 	= $user_permissions->user_operatingprocedures_access;
			$_SESSION['user']['user_admin'] 						= $user_permissions->user_admin;
			
		}
		
		static function checkAccess($type, $level, $denypage) {
			
			$user_food_access 					= $_SESSION['user']['user_food_access'];
			$user_employees_access 				= $_SESSION['user']['user_employees_access'];
			$user_healthsafety_access 			= $_SESSION['user']['user_healthsafety_access'];
			$user_operatingprocedures_access 	= $_SESSION['user']['user_operatingprocedures_access'];
			// $user_user_access 					= $_SESSION['user']['user_edit_users'];
			
			switch($type) {
				case "food":
					switch($level) {
						case 1:
							// Requesting view access
							if(in_array($user_food_access, array(1, 2))) return true;
							break;
						case 2:
							// Requesting edit access
							if(in_array($user_food_access, array(2))) return true;
							break;
					}
					break;
				case "employees":
					switch($level) {
						case 1:
							// Requesting view access
							if(in_array($user_employees_access, array(1, 2))) return true;
							break;
						case 2:
							// Requesting edit access
							if(in_array($user_employees_access, array(2))) return true;
							break;
					}
					break;
				case "healthsafety":
					switch($level) {
						case 1:
							// Requesting view access
							if(in_array($user_healthsafety_access, array(1, 2))) return true;
							break;
						case 2:
							// Requesting edit access
							if(in_array($user_healthsafety_access, array(2))) return true;
							break;
					}
					break;
				case "operatingprocedures":
					switch($level) {
						case 1:
							// Requesting view access
							if(in_array($user_operatingprocedures_access, array(1, 2))) return true;
							break;
						case 2:
							// Requesting edit access
							if(in_array($user_operatingprocedures_access, array(2))) return true;
							break;
					}
					break;
				case "users":
					switch($level) {
						case 1:
							// Requesting view access
							if(in_array($user_healthsafety_access, array(1, 2))) return true;
							break;
						case 2:
							// Requesting edit access
							if(in_array($user_healthsafety_access, array(2))) return true;
							break;
					}
					break;
			}
			
			if($denypage) {
				View::renderTemplate('header', $data);
				View::render('access/nopermission', $data);
				View::renderTemplate('footer', $data);
				exit();
			} else {
				return false;
			}
			
		}
		
		static function is_admin() {
			
			if($_SESSION['user']['user_admin']) {
				return true;
			} else {
				return false;
			}
			
		}
		
	}
		
?>