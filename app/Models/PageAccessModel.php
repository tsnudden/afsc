<?php 
namespace Models;

use Core\Model;

class PageAccessModel extends Model {
    
    function __construct(){
		
        parent::__construct();
		
		$this->logPage();
		
    }
	
	function logPage() {
		
		$data = array(	"access_url" => $_SERVER['REDIRECT_URL'],
						"ip_address" => $_SERVER['REMOTE_ADDR']);
						
		$this->db->insert(PREFIX."_page_access", $data);
		
	}
	
	function getLog() {
		
		return $this->db->select("Select * From ".PREFIX."_page_access");
		
	}
	
}
?>