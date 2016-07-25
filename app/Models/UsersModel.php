<?php 
namespace Models;

use Core\Model;

class UsersModel extends Model {
    
    function __construct(){
		
        parent::__construct();
		
    }
	
	function getUsers() {
		
		$users = $this->db->select("Select * From ".PREFIX."_users Where user_status = 1");
		
		return $users;
		
	}
	
	function getUser($id) {
		
		$user = $this->db->select("Select * From ".PREFIX."_users Where user_id = " . $id);
		
		return $user[0];
		
	}
	
	function getUserPermissions($id) {
		
		$user = $this->db->select("Select user_food_access, user_employees_access, user_healthsafety_access, user_operatingprocedures_access, user_admin From ".PREFIX."_users Where user_id = " . $id);
		
		return $user[0];
		
	}
	
	function addUser($data) {
		
		return $this->db->insert(PREFIX."_users", $data);
		
	}
	
	function updateUser($data, $where) {
		
		if($where['user_id'] == $_SESSION['user']['user_id']) {
			$_SESSION['user']['user_username'] = $data['user_username'];
			$_SESSION['user']['user_level'] = $data['user_level'];
		}
		
		return $this->db->update(PREFIX."_users", $data, $where);
		
	}
	
	function deleteUser($where) {
		
		return $this->db->delete(PREFIX."_users", $where);
		
	}
	
	function loginAttempt($username, $password) {
		$q = $this->db->select("Select 
									*
								From 
									".PREFIX."_users 
								Where 
									".PREFIX."_users.user_username = '" . $username . "' And
									".PREFIX."_users.user_password = '" . sha1($password) . "'
								");
		
		if(is_array($q) && !empty($q)) {
			// Valid user
			$_SESSION['user'] = array(	"user_id" 			=> $q[0]->user_id, 
										"user_username" 	=> $q[0]->user_username,
										"user_level" 		=> $q[0]->user_level,
										"user_food_access" 	=> $q[0]->user_food_access,
										"user_employees_access" 	=> $q[0]->user_employees_access,
										"user_healthsafety_access" 	=> $q[0]->user_healthsafety_access
										);
										
			return true;
		} else {
			return false;
		}
	}

	
}
?>