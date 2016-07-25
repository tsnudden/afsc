<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\NotificationHelper;
use Helpers\AccessHelper;
use \Models\HealthSafetyModel;

class HealthSafety extends Controller
{
	
	public $m;
	
    public function __construct() {
		
        parent::__construct();
		
		AccessHelper::checkAccess("healthsafety", 1, 1);
		
		$this->m = new \Models\HealthSafetyModel();
		
		$this->nh = new \Helpers\NotificationHelper();
		
    }
	
    public function index() {
		
		$data['items'] = $this->m->getHealthAndSafetyItems();
		$data['title'] = "Health &amp; Safety";
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/index', $data);
        View::renderTemplate('footer', $data);
		
    }
	
    public function viewdocs() {
		
		$data['item'] = $this->m->getHealthAndSafetyItem($_GET['id']);
		// echo "<pre>";
		// print_r($data['item']);
		// exit();
		$data['items'] = $this->m->getHealthAndSafetyItemDocs($_GET['id']);
		$data['title'] = $data['item']->item_name . " Documents";
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/viewdocs', $data);
        View::renderTemplate('footer', $data);
		
    }
	
    public function uploadDocument() {
		
		$data['item'] = $this->m->getHealthAndSafetyItem($_GET['id']);
		// echo "<pre>";
		// print_r($data['item']);
		// exit();
		$data['items'] = $this->m->getHealthAndSafetyItemDocs($_GET['id']);
		$data['title'] = $data['item']->item_name . " Documents";
		
		if(isset($_POST['doc_name'])) {
			
			// Adding
			$data = $_POST;
			
			if($this->m->uploadDocument($data)) {
				$this->nh->note("The document was successfully uploaded", "success");
				// exit();
				header("Location: viewdocs?id=" . $_GET['id']);
			} else {
				$this->nh->note("The document could not be uploaded", "error");
				// exit();
				header("Location: viewdocs?id=" . $_GET['id']);
			}
			exit();
		}
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/uploadDocument', $data);
        View::renderTemplate('footer', $data);
		
    }
	
    public function deleteDocument() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		$where = array("doc_id" => $_GET['docId']);
		
		if($this->m->deleteDocument($where)) {
			$this->nh->note("The document was successfully deleted", "success");
			$this->viewdocs();
		} else {
			$this->nh->note("The document could not be deleted", "error");
			$this->viewdocs();
		}
		
    }
	
    public function add() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		if(isset($_POST['item_name'])) {
			
			// Adding
			$data = $_POST;
			
			$data['item_expiry_date'] = $this->db_date($data['item_expiry_date']);
			$data['item_last_inspected'] = $this->db_date($data['item_last_inspected']);
			
			if($data['remind'] == "on") {
				$data['remind'] = 1;
			} else {
				$data['remind'] = 0;
			}
			
			if($num = $this->m->addHealthSafetyItem($data)) {
				$this->nh->note("The item was successfully added", "success");
				header("Location: /health-and-safety");
			} else {
				$this->nh->note("The item could not be added", "error");
				header("Location: /health-and-safety");
			}
			exit();
		}
		
		$data['title'] = "Add Health &amp; Safety Item";
		$data['categories'] = $this->m->getCategories();
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/add', $data);
        View::renderTemplate('footer', $data);
    }
	
    public function edit() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		if(isset($_POST['item_name'])) {
			
			// Editing
			$data = $_POST;
			
			if($data['remind'] == "on") {
				$data['remind'] = 1;
			} else {
				$data['remind'] = 0;
			}
			
			$data['item_expiry_date'] = $this->db_date($data['item_expiry_date']);
			$data['item_last_inspected'] = $this->db_date($data['item_last_inspected']);
			
			$where = array("item_id" => $_GET['id']);
			
			if($num = $this->m->updateHealthSafetyItem($data, $where)) {
				$this->nh->note("The item was successfully updated", "success");
				header("Location: /health-and-safety");
			} else {
				$this->nh->note("The item could not be updated", "error");
				header("Location: /health-and-safety");
			}
			exit();
		}
		
		$data['item'] = $this->m->getHealthAndSafetyItem($_GET['id']);
		$data['categories'] = $this->m->getCategories();
		$data['title'] = "Edit Health &amp; Safety Item";
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/edit', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function manageCategories() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		$data['title'] = "Manage Health & Safety Categories";
		$data['categories'] = $this->m->getCategories();
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/categories/index', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function addCategory() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		if(isset($_POST['category_name'])) {
			
			// Adding
			$data = $_POST;
			
			if($num = $this->m->addCategory($data)) {
				$this->nh->note("The category was successfully added", "success");
			} else {
				$this->nh->note("The category could not be added", "error");
			}
			$this->manageCategories();
			exit();
		}
		
		$data['title'] = "Add Category";
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/categories/add', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function editCategory() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		if(isset($_POST['category_name'])) {
			
			// Adding
			$data = $_POST;
			
			$where = array("category_id" => $_GET['id']);
			
			
			if($num = $this->m->editCategory($data, $where)) {
				$this->nh->note("The category was successfully edited", "success");
			} else {
				$this->nh->note("The category could not be edited", "error");
			}
			$this->manageCategories();
			exit();
			
		}
		
		$data['title'] = "Edit Category";
		$data['category'] = $this->m->getCategory($_GET['id']);
		
        View::renderTemplate('header', $data);
        View::render('healthsafety/categories/edit', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function deleteCategory() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		$where = array("category_id" => $_GET['id']);
		
		if($this->m->deleteCategory($where)) {
			$this->nh->note("The category was successfully deleted", "success");
		} else {
			$this->nh->note("The category could not be deleted", "error");
		}
		$this->manageCategories();
		
    }
	
	public function delete() {
		
		AccessHelper::checkAccess("healthsafety", 2, 1);
		
		$where = array("item_id" => $_GET['id']);
		
		if($this->m->deleteHealthSafetyItem($where)) {
			$this->nh->note("The item was successfully deleted", "success");
			$this->index();
		} else {
			$this->nh->note("The item could not be deleted", "error");
			$this->index();
		}
		
	}
	
	public function db_date($date) {
		$split = explode("/", $date);
		return $split[2] . "-" . $split[1] . "-" . $split[0];
	}
	
}