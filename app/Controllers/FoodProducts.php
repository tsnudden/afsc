<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\NotificationHelper;
use Helpers\AccessHelper;
use \Models\FoodProductModel;

class FoodProducts extends Controller
{
	
	public $fpm;
	
    public function __construct()
    {
        parent::__construct();
		
		AccessHelper::checkAccess("food", 1, 1);
		
		$this->fpm = new \Models\FoodProductModel();
		
		$this->nh = new \Helpers\NotificationHelper();
		
    }

    /**
     * Define Index page title and load template files
     */
    public function index()
    {
		
        $data['title'] = $this->language->get("Food Products");
        // $data['welcome_message'] = $this->language->get('welcome_message');
		
		$data['food_products'] = $this->fpm->getProducts();
		
        View::renderTemplate('header', $data);
        View::render('food-products/index', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function viewProduct() {
        $data['product'] = $this->fpm->getProduct($_GET['id']);
        $data['title'] = $data['product']->food_product_name;
		
        View::renderTemplate('header', $data);
        View::render('food-products/view', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function editProduct() {
        
		AccessHelper::checkAccess("food", 2, 1);
		
		if(isset($_POST['food-product-name'])) {
			
			// Updating
			$data = array("food_product_name" => $_POST['food-product-name']);
			
			$where = array("food_product_id" => $_GET['id']);
			
			$this->fpm->editProduct($data, $where);
			
			header("Location: /food-products");
			exit();
			
		}
		
		$data['product'] = $this->fpm->getProduct($_GET['id']);
        $data['title'] = $data['product']->food_product_name;
		
        View::renderTemplate('header', $data);
        View::render('food-products/edit', $data);
        View::renderTemplate('footer', $data);
    }
	
	// Add Product Page
	public function addProduct() {
		
		AccessHelper::checkAccess("food", 2, 1);
		
		if(isset($_POST['food-product-name'])) {
			// Adding Product
			
			$data = array("food_product_name" => $_POST['food-product-name']);
			
			if($this->fpm->addProduct($data)) {
				$this->nh->note("The product was successfully added to the database", "success");
			} else {
				$this->nh->note("The product could not be added to the database", "error");
			}
			header("Location: /food-products");
			exit();
		}
		
		View::renderTemplate('header', $data);
        View::render('food-products/add', $data);
        View::renderTemplate('footer', $data);
	}
	
	public function deleteProduct() {
		
		AccessHelper::checkAccess("food", 2, 1);
		
		if(isset($_GET['id'])) {
			// Deleting Product
			
			$data = array("food_product_id" => $_GET['id']);
			
			if($this->fpm->deleteProduct($data)) {
				$this->nh->note("The product was deleted from the database", "success");
			} else {
				$this->nh->note("The product could not be deleted from the database", "error");
			}
			header("Location: /food-products");
			exit();
		}
		
	}
	
	public function addIngredient() {
		
		AccessHelper::checkAccess("food", 2, 1);
		
		$data = array("ingredient_name" => $_POST['ingredient-name'], "food_product_id" => $_POST['product-id']);
		if($this->fpm->addIngredient($data)) {
			$this->nh->note("The ingredient was successfully added to the database", "success");
		} else {
			$this->nh->note("The ingredient could not be added to the database", "error");
		}
		// exit();
		header("Location: /food-products/view?id=" . $_POST['product-id']);
		exit();
	}
	
	public function editIngredient() {
        
		AccessHelper::checkAccess("food", 2, 1);
		
		if(isset($_POST['ingredient-name'])) {
			
			// Updating
			$data = array("ingredient_name" => $_POST['ingredient-name']);
			
			$where = array("id" => $_POST['ingredient-id']);
			
			$this->fpm->editIngredient($data, $where);
			
			header("Location: /food-products/view?id=" . $_POST['product-id']);
			exit();
			
		}
		
		$data['ingredient'] = $this->fpm->getIngredient($_GET['id']);
        $data['title'] = $data['ingredient']->ingredient_name;
		
        View::renderTemplate('header', $data);
        View::render('food-products/editIngredient', $data);
        View::renderTemplate('footer', $data);
    }
	
	public function deleteIngredient() {
		
		AccessHelper::checkAccess("food", 2, 1);
		
		$data = array("id" => $_GET['ingredient_id'], "food_product_id" => $_GET['id']);
		if($this->fpm->deleteIngredient($data)) {
			$this->nh->note("The ingredient was successfully deleted", "success");
		} else {
			$this->nh->note("The ingredient could not be deleted", "error");
		}
		// exit();
		header("Location: /food-products/view?id=" . $_GET['id']);
		exit();
	}
	
}
