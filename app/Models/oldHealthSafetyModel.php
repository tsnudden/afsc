<?php 
namespace Models;

use Core\Model;

class HealthSafetyModel extends Model {
    
    function __construct(){
		
        parent::__construct();
		
    }
	
	function getHealthAndSafetyItems() {
		
		$items = $this->db->select("SELECT ".PREFIX."_health_and_safety_items.*, ".PREFIX."_health_and_safety_categories.category_name FROM ".PREFIX."_health_and_safety_items Left Join ".PREFIX."_health_and_safety_categories On ".PREFIX."_health_and_safety_items.item_category = ".PREFIX."_health_and_safety_categories.category_id WHERE 1");
		
		return $items;
		
	}
	
	function getAllHealthSafetyNoReminder() {
		
		return $this->db->select("Select * From ".PREFIX."_health_and_safety_items Where item_status != 4 And reminder_sent = 0 And remind = 1"); 
		
	}
	
	function getHealthAndSafetyItem($id) {
		
		$item = $this->db->select("Select * From ".PREFIX."_health_and_safety_items Where item_id = " . $id . " And item_status = 1");
		
		return $item[0];
		
	}
	
	function getCategories() {
		
		$items = $this->db->select("Select * From ".PREFIX."_health_and_safety_categories");
		
		return $items;
		
	}
	
	function getCategory($id) {
		
		$item = $this->db->select("Select * From ".PREFIX."_health_and_safety_categories Where category_id = " . $id);
		
		return $item[0];
		
	}
	
	function addCategory($data) {
		
		if($this->db->insert(PREFIX."_health_and_safety_categories", $data)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function editCategory($data, $where) {
		
		if($this->db->update(PREFIX."_health_and_safety_categories", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function addHealthSafetyItem($data) {
		
		if($this->db->insert(PREFIX."_health_and_safety_items", $data)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function deleteCategory($where) {
		
		if($this->db->delete(PREFIX."_health_and_safety_categories", $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function updateHealthSafetyItem($data, $where) {
		
		if($this->db->update(PREFIX."_health_and_safety_items", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function deleteHealthSafetyItem($where) {
		
		if($this->db->delete(PREFIX."_health_and_safety_items", $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function sendHealthSafetyExpiryNotification($item_id) {
		
		$healthsafety_item 	= $this->getHealthAndSafetyItem($item_id);
		
		$subject = "Notification: " . $healthsafety_item->item_name . " is Expiring Soon";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <reminders@afsc.co.uk>' . "\r\n";
		$headers .= 'bcc: '. ADMIN2_EMAIL .', '. ADMIN3_EMAIL . "\r\n";

		
		$body = "This is an automated message to notify you that the following Health & Safety item will soon expire:\r\n\r\n";
		
		$body .= "Item Name: " . $healthsafety_item->item_name . "\r\n";
		$body .= "Expiry Date: " . date("jS F Y", strtotime($healthsafety_item->item_expiry_date)) . "\r\n";
		
		$body .= "\r\nThank you";
		
		if(mail(ADMIN_EMAIL, $subject, $body, $headers)) {
			
			if($this->setHealthSafetyReminderSent($healthsafety_item->item_id)) {
				
				echo "Health & Safety reminders processed successfully - ";
				
			}
			
		} else {
			
			echo "Error sending mail";
			
		}
		
	}
	
	function setHealthSafetyReminderSent($item_id) {
		
		$data = array("reminder_sent" => 1);
		
		$where = array("item_id" => $item_id);
		
		if($this->db->update(PREFIX."_health_and_safety_items", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
}
?>