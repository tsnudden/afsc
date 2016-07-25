<?php 
namespace Models;

use Core\Model;

class FoodProductModel extends Model {
    
    function __construct(){
		
        parent::__construct();
		
    }
	
	function getProducts() {
		
		$products = $this->db->select("Select * From ".PREFIX."_food_products");
		
		foreach($products as &$product) {
			$product->ingredients = $this->getIngredients($product->food_product_id);
		}
		
		return $products;
		
	}
	
	function getProduct($id) {
		$product = $this->db->select("Select * From ".PREFIX."_food_products Where food_product_id = " . $id);
		
		$product[0]->ingredients = $this->getIngredients($product[0]->food_product_id);
		
		return $product[0];
		
	}
	
	function getIngredients($id) {
		
		return $this->db->select("Select * From ".PREFIX."_ingredients Where food_product_id = " . $id); 
		
	}
	
	function getIngredient($id) {
		
		return $this->db->select("Select * From ".PREFIX."_ingredients Where id = " . $id)[0]; 
		
	}
	
	function addProduct($data) {
		
		if($this->db->insert(PREFIX.'_food_products', $data)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function editProduct($data, $where) {
			
		if($this->db->update(PREFIX."_food_products", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function deleteProduct($data) {
		
		if($this->db->delete(PREFIX.'_food_products', $data)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function addIngredient($data) {
		if($this->db->insert(PREFIX."_ingredients", $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	function deleteIngredient($data) {
		if($this->db->delete(PREFIX."_ingredients", $data)) {
			return true;
		} else {
			return false;
		}
	}
	
	function editIngredient($data, $where) {
		
		if($this->db->update(PREFIX."_ingredients", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
}
?>