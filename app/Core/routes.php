<?php
/**
 * Routes - all standard routes are defined here.
 */

/** Create alias for Router. */
use Core\Router;
use Helpers\Hooks;

/* Force user to login unless running cron */
if(!isset($_SESSION['user']) && $_SERVER['REDIRECT_URL'] != "/reminders/run") {
	$c = new Controllers\Users();
	$c->login();
	exit();
}

/** Define routes. */

// Router::any('', 							'Controllers\FoodProducts@index');
Router::any('', function() {
	header("Location: /food-products");
	exit();
});
Router::any('food-products', 				'Controllers\FoodProducts@index');
Router::any('food-products/add', 			'Controllers\FoodProducts@addProduct');
Router::any('food-products/delete', 		'Controllers\FoodProducts@deleteProduct');
Router::any('food-products/view', 			'Controllers\FoodProducts@viewProduct');
Router::any('food-products/edit', 			'Controllers\FoodProducts@editProduct');
Router::any('food-products/addIngredient', 	'Controllers\FoodProducts@addIngredient');
Router::any('food-products/editIngredient', 'Controllers\FoodProducts@editIngredient');
Router::any('food-products/deleteIngredient', 'Controllers\FoodProducts@deleteIngredient');

Router::any('employees', 					'Controllers\Employees@index');
Router::any('employees/view', 				'Controllers\Employees@view');
Router::any('employees/add', 				'Controllers\Employees@add');
Router::any('employees/add-new-start', 		'Controllers\Employees@addNewStart');
Router::any('employees/edit', 				'Controllers\Employees@edit');
Router::any('employees/delete', 			'Controllers\Employees@delete');
Router::any('employees/qualification/edit', 'Controllers\Employees@editQualification');
Router::any('employees/qualification/add', 	'Controllers\Employees@addQualification');
Router::any('employees/qualification/delete','Controllers\Employees@deleteQualification');
Router::any('employees/new-start-item/complete','Controllers\Employees@markNewStartComplete');
Router::any('employees/new-start-item/incomplete','Controllers\Employees@markNewStartIncomplete');
Router::any('employees/new-start-item/delete','Controllers\Employees@deleteNewStart');
Router::any('employees/new-start-item/edit','Controllers\Employees@editNewStart');

Router::any('health-and-safety','Controllers\HealthSafety@index');
Router::any('health-and-safety/add','Controllers\HealthSafety@add');
Router::any('health-and-safety/edit','Controllers\HealthSafety@edit');
Router::any('health-and-safety/delete','Controllers\HealthSafety@delete');
Router::any('health-and-safety/viewdocs','Controllers\HealthSafety@viewdocs');
Router::any('health-and-safety/uploadDocument','Controllers\HealthSafety@uploadDocument');
Router::any('health-and-safety/deleteDocument','Controllers\HealthSafety@deleteDocument');

Router::any('operating-procedures','Controllers\OperatingProcedures@index');
Router::any('operating-procedures/edit','Controllers\OperatingProcedures@edit');
Router::any('operating-procedures/view','Controllers\OperatingProcedures@view');
Router::any('operating-procedures/add','Controllers\OperatingProcedures@add');
Router::any('operating-procedures/delete','Controllers\OperatingProcedures@delete');
Router::any('operating-procedures/print','Controllers\OperatingProcedures@print_pdf');
Router::any('operating-procedures/email','Controllers\OperatingProcedures@email');

Router::any('monitor','Controllers\Monitor@index');

Router::any('reminders/run', 'Controllers\Reminders@reminders');

Router::any('/health-and-safety/categories/manage', 'Controllers\HealthSafety@manageCategories');
Router::any('/health-and-safety/categories/add', 'Controllers\HealthSafety@addCategory');
Router::any('/health-and-safety/categories/delete', 'Controllers\HealthSafety@deleteCategory');
Router::any('/health-and-safety/categories/edit', 'Controllers\HealthSafety@editCategory');

Router::any('/users', 'Controllers\Users@index');
Router::any('/users/add', 'Controllers\Users@add');
Router::any('/users/edit', 'Controllers\Users@edit');
Router::any('/users/delete', 'Controllers\Users@delete');
Router::any('/users/delete', 'Controllers\Users@delete');
Router::any('/users/logout', 'Controllers\Users@logout');

/** Module routes. */
$hooks = Hooks::get();
$hooks->run('routes');

/** If no route found. */
Router::error('Core\Error@index');

/** Turn on old style routing. */
Router::$fallback = false;

/** Execute matched routes. */
Router::dispatch();
