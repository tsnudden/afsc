<?php 
namespace Models;

use Core\Model;
use Helpers\PhpMailer;

class OperatingProceduresModel extends Model {
    
    function __construct(){
		
        parent::__construct();
		
    }
	
	function getOperatingProcedures() {
		
		$operatingprocedures = $this->db->select("Select * From ".PREFIX."_operating_procedures Where operating_procedure_status = 1");
		
		return $operatingprocedures;
		
	}
	
	function getOperatingProcedure($id) {
		
		$operatingprocedure = $this->db->select("Select * From ".PREFIX."_operating_procedures Where operating_procedure_id = " . $id);
		
		return $operatingprocedure[0];
		
	}
	
	function updateOperatingProcedure($data, $where) {
		
		if($this->db->update(PREFIX."_operating_procedures", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function addOperatingProcedure($data) {
		
		if($num = $this->db->insert(PREFIX."_operating_procedures", $data)) {
			return $num;
		} else {
			return false;
		}
		
	}
	
	function sendOperatingProcedureEmail($data) {
		
		require("app/Helpers/PhpMailer/PhpMailer.php");
		
		$failed = false;
		
		$email = new \Helpers\PhpMailer\PHPMailer();
		$email->From      = ADMIN2_EMAIL;
		$email->FromName  = 'AFSC';
		$email->Subject   = 'AFSC: You have been sent an Operating Procedure';
		
		$body = "You have been sent an Operating Procedure by the user: " . $_SESSION['user']['user_username'] . "\r\n\r\n";
		$body .= "Your file is attached to this email as a PDF.\r\n\r\n";
		$body .= "Message:\r\n " . $data['operating_procedure_email_message'] . "\r\n";
		
		$email->Body      = $body;
		
		$addresses = split(", ", $data['operating_procedure_email_send_to']);
		foreach($addresses as $address) {
		
			$email->AddAddress($address);

			$file_to_attach = 'app/pdfs';
			
			$email->AddAttachment("app/pdfs/" . $data['pdf_filename'], $data['pdf_filename'], "base64", "application/pdf");
			
			if(!$email->Send()) {
				$failed = true;
			}
			
		}
		
		if(!$failed) {
			return true;
		} else {
			return false;
		}
		
		exit();
		
	}
	
	/*
	function getNewStartList($id) {
				
		return $this->db->select("Select * From ".PREFIX."_new_start_items Where employee_id = " . $id);
		
	}
	
	function getQualification($id) {
		
		$qualification = $this->db->select("Select * From ".PREFIX."_qualifications Where qualification_id = " . $id);
		
		return $qualification[0];
		
	}
	
	function getQualifications($id) {
		
		return $this->db->select("Select * From ".PREFIX."_qualifications Where employee_id = " . $id . " And qualification_status != 4"); 
		
	}
	
	function getAllQualificationsNoReminder() {
		
		return $this->db->select("Select * From ".PREFIX."_qualifications Where qualification_status != 4 And reminder_sent = 0 And remind = 1"); 
		
	}
	
	function sendQualificationExpiryNotification($qualification_id, $employee_id) {
		
		$qualification 	= $this->getQualification($qualification_id);
		
		$employee 		= $this->getEmployee($employee_id);
		
		$subject = "Notification: " . $employee->employee_name . " Has a Qualification Expiring Soon";
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <reminders@afsc.co.uk>' . "\r\n";
		$headers .= 'bcc: '. ADMIN2_EMAIL .', '. ADMIN3_EMAIL . "\r\n";
		
		$body = "This is an automated message to notify you that the following qualification will soon expire:\r\n\r\n";
		
		$body .= "Employee: " . $employee->employee_name . "\r\n";
		$body .= "Qualification: " . $qualification->qualification_name . "\r\n";
		$body .= "Expiry Date: " . date("jS F Y", strtotime($qualification->qualification_expiry_date)) . "\r\n";
		
		$body .= "\r\nThank you";
		
		if(mail(ADMIN_EMAIL, $subject, $body, $headers)) {
			
			if($this->setQualificationReminderSent($qualification->qualification_id)) {
				
				echo "Qualification reminders processed successfully - ";
				
			}
			
		} else {
			
			echo "Error sending mail";
			
		}
		
	}
	
	function setQualificationReminderSent($qualification_id) {
		
		$data = array("reminder_sent" => 1);
		
		$where = array("qualification_id" => $qualification_id);
		
		if($this->db->update(PREFIX."_qualifications", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function updateQualification($data, $where) {
		
		if($this->db->update(PREFIX."_qualifications", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function addQualification($data) {
		
		if($this->db->insert(PREFIX."_qualifications", $data)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function addNewStartItem($data) {
		
		if($this->db->insert(PREFIX."_new_start_items", $data)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function markNewStartComplete($data, $where) {
		
		if($this->db->update(PREFIX."_new_start_items", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function markNewStartIncomplete($data, $where) {
		
		if($this->db->update(PREFIX."_new_start_items", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function deleteNewStart($where) {
		if($this->db->delete(PREFIX."_new_start_items", $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function getNewStart($id) {
		
		$newStart = $this->db->select("Select * From ".PREFIX."_new_start_items Where item_id = " . $id);	
		
		return $newStart[0];
		
	}
	
	function updateNewStartItem($data, $where) {
		
		if($this->db->update(PREFIX."_new_start_items", $data, $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	
	function deleteQualification($where) {
		
		if($this->db->delete(PREFIX."_qualifications", $where)) {
			return true;
		} else {
			return false;
		}
		
	}
	*/
	
	/*
	function addNewStartEmployee($data, $newStartList) {
		// echo "<pre>";
		// print_r($data);
		// exit();
		if($num = $this->db->insert(PREFIX."_employees", $data)) {
			
			// add new start list
			
			if(!empty($newStartList)) {
				// echo "<pre>";
				// print_r($newStartList);
				// exit();
				foreach($newStartList as $key=>$value) {
					// echo $value;
					// exit();
					$data = array("item_name" => $value, "employee_id" => $num, "item_status" => 0);
					
					$this->db->insert(PREFIX."_new_start_items", $data);
					
				}
			}
			
			return $num;
		} else {
			return false;
		}
		
	}
	
	function getNewStartDefaultList() {
		
		return $this->db->select("Select * From ".PREFIX."_new_start_default_items");
		
	}
	*/
	
	// function delete($data) {
		
		// $data = array("
		
		// if($this->db->delete(PREFIX."_employees", $data)) {
		// if($this->db->update(PREFIX."_employees", $data, $where) {
			// return true;
		// } else {
			// return false;
		// }
		
	// }
	
}
?>