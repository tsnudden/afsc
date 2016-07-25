<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use \Models\EmployeesModel;
use \Models\RemindersModel;

class Reminders extends Controller {
	
	public $m;
	
	public $em;
	
	public $hsm;
	
    public function __construct() {
        
		parent::__construct();
		
		$this->m = new \Models\RemindersModel();
		
		$this->em = new \Models\EmployeesModel();
		
		$this->hsm = new \Models\HealthSafetyModel();
		
    }
	
	public function reminders() {
		
		$this->checkQualifications();
		
		$this->checkHealthAndSafety();
		
		exit();
		
	}
	
	public function checkQualifications() {
		
		$qualifications = $this->em->getAllQualificationsNoReminder();
		
		foreach($qualifications as $q) {
			
			$cdate = mktime(0, 0, 0, date("m", strtotime($q->qualification_expiry_date)), date("d", strtotime($q->qualification_expiry_date)), date("Y", strtotime($q->qualification_expiry_date)), 0);
			
			$today = time();
			
			$difference = (int)(($cdate - $today) / 86400);
			
			if($difference <= 30 && $difference >= 0) {
				
				$this->em->sendQualificationExpiryNotification($q->qualification_id, $q->employee_id);
				
				echo "Sent 1 email<br />";
				
			}
			
		}
		
	}
	
	public function checkHealthAndSafety() {
		
		$healthsafety_items = $this->hsm->getAllHealthSafetyNoReminder();
		
		foreach($healthsafety_items as $q) {
			
			$cdate = mktime(0, 0, 0, date("m", strtotime($q->item_expiry_date)), date("d", strtotime($q->item_expiry_date)), date("Y", strtotime($q->item_expiry_date)), 0);
			
			$today = time();
			
			$difference = (int)(($cdate - $today) / 86400);
			
			if($difference <= 30 && $difference >= 0) {
				
				$this->hsm->sendHealthSafetyExpiryNotification($q->item_id);
				
				echo "Sent 1 email<br />";
				
			}
			
		}
		
	}
	
}

?>