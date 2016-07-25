<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\NotificationHelper;
use Helpers\AccessHelper;
use \Models\EmployeesModel;

class OperatingProcedures extends Controller
{
	
	public $m;
	
    public function __construct() {
		
        parent::__construct();
		
		AccessHelper::checkAccess("operatingprocedures", 1, 1);
		
		$this->m = new \Models\OperatingProceduresModel();
		
		$this->nh = new \Helpers\NotificationHelper();
		
    }
	
    public function index() {
		
        $data['title'] = $this->language->get("Operational Procedures");
		
		$data['operatingprocedures'] = $this->m->getOperatingProcedures();
		
        View::renderTemplate('header', $data);
        View::render('operating-procedures/index', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function view() {
        
		AccessHelper::checkAccess("operatingprocedures", 1, 1);
		
		if(isset($_POST['item-name'])) {
			
			// Adding new start item
			
			$data = array("item_name" => $_POST['item-name'], "employee_id" => $_GET['id']);
			
			if($this->m->addNewStartItem($data)) {
				$this->nh->note("The item was successfully added", "success");
			} else {
				$this->nh->note("The item could not be added", "error");
			}
			
		}
		
		$data['operatingprocedure'] = $this->m->getOperatingProcedure($_GET['id']);
		$data['title'] = $data['operatingprocedure']->operating_procedure_name;
		
        View::renderTemplate('header', $data);
        View::render('operating-procedures/view', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function add() {
		
		AccessHelper::checkAccess("operatingprocedures", 2, 1);
		
        if(isset($_POST['operating_procedure_name'])) {
			
			// Adding
			
			$data = $_POST;
			
			if($num = $this->m->addOperatingProcedure($data, $where)) {
				$this->nh->note("The operating procedure was successfully added", "success");
				header("Location: /operating-procedures");
			} else {
				$this->nh->note("The operating procedure could not be added", "error");
			}
			exit();
			
		}
		
		$data['title'] = "Add Operating Procedure";
		
        View::renderTemplate('header', $data);
        View::render('operating-procedures/add', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function edit() {
		
		AccessHelper::checkAccess("operatingprocedures", 2, 1);
		
        if(isset($_POST['operating_procedure_name'])) {
			
			// Updating
			
			$data = $_POST;
			
			$where = array("operating_procedure_id" => $_GET['id']);
			
			if($this->m->updateOperatingProcedure($data, $where)) {
				$this->nh->note("The operating procedure was successfully updated", "success");
			} else {
				$this->nh->note("The operating procedure could not be updated", "error");
			}
			header("Location: /operating-procedures/view?id=" . $_GET['id']);
			exit();
			
		}
		
		$data['operatingprocedure'] = $this->m->getOperatingProcedure($_GET['id']);
		$data['title'] = $data['operatingprocedure']->operating_procedure_name;
		
        View::renderTemplate('header', $data);
        View::render('operating-procedures/edit', $data);
        View::renderTemplate('footer', $data);
		
    }
	
	public function delete() {
		
		AccessHelper::checkAccess("operatingprocedures", 2, 1);
		
		if(isset($_GET['id'])) {
			
			$data = array("operating_procedure_status" => 0);
			$where = array("operating_procedure_id" => $_GET['id']);
			
			// if($this->m->delete($data)) {
			if($this->m->updateOperatingProcedure($data, $where)) {
				$this->nh->note("The operating procedure was successfully deleted", "success");
			} else {
				$this->nh->note("The operating procedure could not be deleted", "error");
			}
			header("Location: /operating-procedures");
			exit();
			
		}
		
	}
	
	public function print_pdf() {
		
		AccessHelper::checkAccess("operatingprocedures", 2, 1);
		
		$this->generate_pdf($data, true, true);
		
	}
	
	public function email() {
		
		AccessHelper::checkAccess("operatingprocedures", 1, 1);
		
        if(isset($_POST['operating_procedure_email_send_to'])) {
			
			// Updating
			
			$data = $_POST;
			
			$data['operatingprocedure'] = $this->m->getOperatingProcedure($_GET['id']);
			
			$data['pdf_filename'] = $this->email_pdf();
			
			if($this->m->sendOperatingProcedureEmail($data)) {
				$this->nh->note("The operating procedure was successfully sent", "success");
			} else {
				$this->nh->note("The operating procedure could not be sent", "error");
			}
			header("Location: /operating-procedures/view?id=" . $_GET['id']);
			exit();
			
		}
		
		$data['operatingprocedure'] = $this->m->getOperatingProcedure($_GET['id']);
		$data['title'] = $data['operatingprocedure']->operating_procedure_name;
		
        View::renderTemplate('header', $data);
        View::render('operating-procedures/email', $data);
        View::renderTemplate('footer', $data);
		
	}
	
	public function email_pdf() {
		
		return $this->generate_pdf($data, false, false);
		
	}
	
	function generate_pdf($data, $output, $print) {
		
		$data['operatingprocedure'] = $this->m->getOperatingProcedure($_GET['id']);
		$data['title'] = $data['operatingprocedure']->operating_procedure_name;
		
		require("app/Helpers/fpdf/pdf_js.php");
		
		// $pdf = new FPDF();
		
		/* ENABLE FOR AUTOPRINT! */
		$pdf = new PDF_AutoPrint();
		
		$pdf->AddPage();
		$pdf->SetFont('Arial','',20);
		
		$pdf->Image('app/templates/default/images/logo.jpg',10,6,60);
		
		$pdf->Ln(20);
		
		$pdf->SetFont('Arial','B',15);
		$pdf->MultiCell(0,5,$data['title'],0,"L");
		
		$pdf->Ln(5);
		
		$pdf->SetFont('Arial','',12);
		$pdf->MultiCell(0,5,$data['operatingprocedure']->operating_procedure_text,0,"L");
		
		$pdf->Ln(20);
		
		$pdf->AliasNbPages();
		
		$pdf->SetFont('Times','',12);
		
		if($output) {
			if($print) {
				/* ENABLE FOR AUTOPRINT! */
				$pdf->AutoPrint(true);
			}
			$pdf->Output();
		} else {
			$name = str_replace(" ", "-", $data['title']) . "_" . strtotime("now") . ".pdf";
			// echo $name;
			// exit();
			$pdf->Output("F", "app/pdfs/" . $name);
			return $name;
			echo "File saved?";
			exit();
		}
		
	}
	
}
