<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\NotificationHelper;
use \Models\EmployeesModel;

class Users extends Controller
{
	
	public $m;
	
    public function __construct() {
		
        parent::__construct();
		
		$this->m = new \Models\UsersModel();
		
		$this->nh = new \Helpers\NotificationHelper();
		
    }
	
    public function index() {
		
        $data['title'] = "Users";
		
		$data['users'] = $this->m->getUsers();
		
        View::renderTemplate('header', $data);
        View::render('users/index', $data);
        View::renderTemplate('footer', $data);
		
    }
	
    public function add() {
		
		if(isset($_POST['user_username'])) {
			
			// Adding
			$data = $_POST;
			
			$data['user_password'] = sha1($data['user_password']);
			
			if($data['user_admin'] == "on") {
				$data['user_admin'] = 1;
			} else {
				$data['user_admin'] = 0;
			}
			
			if($num = $this->m->addUser($data)) {
				$this->nh->note("The user was successfully added", "success");
			} else {
				$this->nh->note("The user could not be added", "error");
			}
			header("Location: /users");
			exit();
		}
		
        $data['title'] = "Add User";
		
        View::renderTemplate('header', $data);
        View::render('users/add', $data);
        View::renderTemplate('footer', $data);
		
    }
	
    public function edit() {
		
		if(isset($_POST['user_username'])) {
			
			// Adding
			$data = $_POST;
			
			if($data['user_password'] != "") {
				$data['user_password'] = sha1($data['user_password']);
			} else {
				unset($data['user_password']);
			}
			
			$where = array("user_id" => $_GET['id']);
			
			if($data['user_admin'] == "on") {
				$data['user_admin'] = 1;
			} else {
				$data['user_admin'] = 0;
			}
			
			if($this->m->updateUser($data, $where)) {
				$this->nh->note("The user was successfully updated", "success");
			} else {
				$this->nh->note("The user could not be updated", "error");
			}
			header("Location: /users");
			exit();
		}
		
        $data['title'] = "Edit User";
        $data['user'] = $this->m->getUser($_GET['id']);
		
        View::renderTemplate('header', $data);
        View::render('users/edit', $data);
        View::renderTemplate('footer', $data);
		
    }
	
    public function delete() {
		
		$where = array("user_id" => $_GET['id']);
		
		if($this->m->deleteUser($where)) {
			$this->nh->note("The user was successfully deleted", "success");
		} else {
			$this->nh->note("The user could not be deleted", "error");
		}
		header("Location: /users");
		exit();
		
        View::renderTemplate('header', $data);
        View::render('users/edit', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function login() {
		
		if(isset($_POST['username']) && $_POST['username'] != "") {
			
			if($this->m->loginAttempt($_POST['username'], $_POST['password'])) {
				$data['failed_attempt'] = false;
				header("Location: /");
				exit();
			} else {
				$data['failed_attempt'] = true;
			}
			
		}
		
        $data['title'] = $this->language->get('Login');
		
        View::renderTemplate('header-not-logged-in', $data);
        View::render('login/login', $data);
        View::renderTemplate('footer-not-logged-in', $data);
		
	}
	
	public function logout() {
		
		session_destroy();
		
		header("Location: /");
		
		exit();
		
	}
	
}