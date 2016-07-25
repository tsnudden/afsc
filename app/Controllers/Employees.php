<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\NotificationHelper;
use Helpers\AccessHelper;
use \Models\EmployeesModel;

class Employees extends Controller
{
	
	public $m;
	
    public function __construct() {
		
        parent::__construct();
		
		AccessHelper::checkAccess("employees", 1, 1);
		
		$this->m = new \Models\EmployeesModel();
		
		$this->nh = new \Helpers\NotificationHelper();
		
    }
	
    public function index() {
		
        $data['title'] = $this->language->get("Employees");
		
		$data['employees'] = $this->m->getEmployees();
		
        View::renderTemplate('header', $data);
        View::render('employees/index', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function view() {
        
		if(isset($_POST['item-name'])) {
			
			// Adding new start item
			
			$data = array("item_name" => $_POST['item-name'], "employee_id" => $_GET['id']);
			
			if($this->m->addNewStartItem($data)) {
				$this->nh->note("The item was successfully added", "success");
			} else {
				$this->nh->note("The item could not be added", "error");
			}
			
		}
		
		$data['employee'] = $this->m->getEmployee($_GET['id']);
		$data['title'] = $data['employee']->employee_name;
		
        View::renderTemplate('header', $data);
        View::render('employees/view', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function add() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
        if(isset($_POST['employee_name'])) {
			
			// Adding
			
			$data = $_POST;
			
			$data['employee_dob'] = $this->db_date($data['employee_dob']);
			
			if($num = $this->m->addEmployee($data)) {
				$this->nh->note("The employee was successfully added", "success");
				header("Location: /employees/view?id=" . $num);
			} else {
				$this->nh->note("The employee could not be added", "error");
				header("Location: /employees/");
			}
			exit();
			
		}
		
		$data['title'] = "Add Employee";
		
        View::renderTemplate('header', $data);
        View::render('employees/add', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function edit() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
        if(isset($_POST['employee_name'])) {
			
			// Updating
			
			$data = $_POST;
			
			$data['employee_dob'] = $this->db_date($data['employee_dob']);
			
			$where = array("employee_id" => $_GET['id']);
			
			if($this->m->updateEmployee($data, $where)) {
				$this->nh->note("The employee was successfully updated", "success");
			} else {
				$this->nh->note("The employee could not be updated", "error");
			}
			header("Location: /employees/view?id=" . $_GET['id']);
			exit();
			
		}
		
		$data['employee'] = $this->m->getEmployee($_GET['id']);
		$data['title'] = $data['employee']->employee_name;
		
        View::renderTemplate('header', $data);
        View::render('employees/edit', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function addNewStart() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
        if(isset($_POST['employee_name'])) {
			
			// Adding
			
			if($_POST['new-start-list'] != "") {
				$newStartList = array_filter(explode("\n", $_POST['new-start-list']));
			} else {
				$newStartList = array();
			}
			
			unset($_POST['new-start-list']);
			
			$data = $_POST;
			
			$data['employee_dob'] = $this->db_date($data['employee_dob']);
			
			if($num = $this->m->addNewStartEmployee($data, $newStartList)) {
				$this->nh->note("The new employee was successfully added", "success");
				header("Location: /employees/view?id=" . $num);
			} else {
				$this->nh->note("The employee could not be added", "error");
				header("Location: /employees/");
			}
			exit();
			
		}
		
		$default_items = $this->m->getNewStartDefaultList();
		
		$comb = "";
		
		foreach($default_items as $item) {
			
			$comb .= $item->item_name . "\r\n";
			
		}
		
		$data['default_list'] = $comb;
		
		// echo "<pre>";
		// print_r($data);
		// exit();
		
		$data['title'] = "Add Employee";
		
        View::renderTemplate('header', $data);
        View::render('employees/addNewStart', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function delete() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
		if(isset($_GET['id'])) {
			
			// $data = array("employee_id" => $_GET['id']);
			$data = array("employee_status" => 0);
			$where = array("employee_id" => $_GET['id']);
			
			// if($this->m->delete($data)) {
			if($this->m->updateEmployee($data, $where)) {
				$this->nh->note("The employee was successfully deleted", "success");
			} else {
				$this->nh->note("The employee could not be deleted", "error");
			}
			header("Location: /employees");
			
		}
		
	}
	
	public function editQualification() {
        
		AccessHelper::checkAccess("employees", 2, 1);
		
		if(isset($_POST['qualification_name'])) {
			
			// Updating
			
			$data = $_POST;
			
			$data['qualification_expiry_date'] = $this->db_date($data['qualification_expiry_date']);
			
			if($data['remind'] == "on") {
				$data['remind'] = 1;
			} else {
				$data['remind'] = 0;
			}
			
			unset($data['employee-id']);
			
			$where = array("qualification_id" => $_GET['id']);
			
			if($this->m->updateQualification($data, $where)) {
				$this->nh->note("The qualification was successfully updated", "success");
			} else {
				$this->nh->note("The qualification could not be updated", "error");
			}
			header("Location: /employees/view?id=" . $_POST['employee-id']);
			exit();
			
		}
		
		$data['qualification'] = $this->m->getQualification($_GET['id']);
		$data['title'] = $data['qualification']->qualification_name;
		
        View::renderTemplate('header', $data);
        View::render('employees/editQualification', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function addQualification() {
        
		AccessHelper::checkAccess("employees", 2, 1);
		
		if(isset($_POST['qualification_name'])) {
			
			// Updating
			
			$data = $_POST;
			
			$data['qualification_expiry_date'] = $this->db_date($data['qualification_expiry_date']);
			
			if($data['remind'] == "on") {
				$data['remind'] = 1;
			} else {
				$data['remind'] = 0;
			}
			
			// unset($data['employee-id']);
			// echo "<pre>";
			// print_r($data);
			// exit();
			if($this->m->addQualification($data)) {
				$this->nh->note("The qualification was successfully updated", "success");
			} else {
				$this->nh->note("The qualification could not be updated", "error");
			}
			header("Location: /employees/view?id=" . $_POST['employee_id']);
			exit();
			
		}
		
		$data['qualification'] = $this->m->getQualification($_GET['id']);
		$data['title'] = $data['qualification']->qualification_name;
		
        View::renderTemplate('header', $data);
        View::render('employees/addQualification', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function deleteQualification() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
		if(isset($_GET['id'])) {
			
			// $data = array("employee_id" => $_GET['id']);
			// $data = array("employee_status" => 0);
			$where = array("qualification_id" => $_GET['id']);
			
			// if($this->m->delete($data)) {
			if($this->m->deleteQualification($where)) {
				$this->nh->note("The qualification was successfully deleted", "success");
			} else {
				$this->nh->note("The qualification could not be deleted", "error");
			}
			header("Location: /employees/view?id=" . $_GET['e']);
			
		}
		
	}
	
	public function db_date($date) {
		$split = explode("/", $date);
		return $split[2] . "-" . $split[1] . "-" . $split[0];
	}
	
	public function markNewStartComplete() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
		$data = array("item_status" => 1);
		
		$where = array("item_id" => $_GET['id']);
		
		if($this->m->markNewStartComplete($data, $where)) {
			$this->nh->note("The item was marked as complete", "success");
			header("Location: /employees/view?id=" . $_GET['e']);
		} else {
			$this->nh->note("The item could not be marked as complete", "error");
			header("Location: /employees/view?id=" . $_GET['e']);
		}
		exit();
		
	}
	
	public function markNewStartIncomplete() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
		$data = array("item_status" => 0);
		
		$where = array("item_id" => $_GET['id']);
		
		if($this->m->markNewStartIncomplete($data, $where)) {
			$this->nh->note("The item was marked as incomplete", "success");
			header("Location: /employees/view?id=" . $_GET['e']);
		} else {
			$this->nh->note("The item could not be marked as incomplete", "error");
			header("Location: /employees/view?id=" . $_GET['e']);
		}
		exit();
		
	}
	
	public function deleteNewStart() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
		$where = array("item_id" => $_GET['id']);
		
		if($this->m->deleteNewStart($where)) {
			$this->nh->note("The item was successfully deleted", "success");
			header("Location: /employees/view?id=" . $_GET['e']);
		} else {
			$this->nh->note("The item could not be deleted", "error");
			header("Location: /employees/view?id=" . $_GET['e']);
		}
		exit();
		
	}
	
	public function editNewStart() {
		
		AccessHelper::checkAccess("employees", 2, 1);
		
        if(isset($_POST['item_name'])) {
			
			// Updating
			
			$data = $_POST;
			
			$where = array("item_id" => $_GET['id']);
			
			if($this->m->updateNewStartItem($data, $where)) {
				$this->nh->note("The item was successfully updated", "success");
			} else {
				$this->nh->note("The item could not be updated", "error");
			}
			header("Location: /employees/view?id=" . $_GET['e']);
			exit();
			
		}
		
		$data['new_start'] = $this->m->getNewStart($_GET['id']);
		
        View::renderTemplate('header', $data);
        View::render('employees/editNewStart', $data);
        View::renderTemplate('footer', $data);
    }
	
}