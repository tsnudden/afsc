<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\NotificationHelper;
use \Models\HealthSafetyModel;

class Monitor extends Controller
{
	
	public $m;
	
    public function __construct() {
		
        parent::__construct();
		
		$this->m = new \Models\PageAccessModel();
		
		$this->nh = new \Helpers\NotificationHelper();
		
    }
	
    public function index() {
		
		// $data['items'] = $this->m->getHealthAndSafetyItems();
		
        View::renderTemplate('header', $data);
        View::render('monitor/index', $data);
        View::renderTemplate('footer', $data);
		
    }
	
}