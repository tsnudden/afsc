<h3>Employees 
<?php
use \Helpers\AccessHelper;
if(AccessHelper::checkAccess("employees", 2, 0)) {
	?>
	<a href="/employees/add"><button class="btn btn-primary">Add Employee</button></a> <a href="/employees/add-new-start"><button class="btn btn-primary">Add New Start Employee</button></a>
	<?php
}
?>
</h3>
<div class="search">
	<div class="search-title">
		SEARCH
	</div>
	<label for="keyword">Keyword</label><br />
	<input id="keyword" name="keyword" type="text" />
</div>
<table id="employees-table" class="table search-table table-hover table-striped table-bordered">
	<thead>
		<td>Name</td>
		<?php
		if(AccessHelper::checkAccess("employees", 2, 0)) {
			?>
			<td>Actions</td>
			<?php
		}
		?>
	</thead>
	<tbody id="employees-body">
		<?php
		foreach($data['employees'] as $employee) {
			// echo "<pre>";
			// print_r($employee);
			// exit();
			
			echo "<tr data-employee-name='" . $employee->employee_name . "'>";
				echo "<td><a href='/employees/view?id=" . $employee->employee_id . "'>" . $employee->employee_name . "</a></td>";
				
				if(AccessHelper::checkAccess("employees", 2, 0)) {
					echo "<td>";
						echo "<a href='/employees/delete?id=" . $employee->employee_id . "' onclick='return confirm(\"Are you sure you want to delete this employee? This will also remove all attached qualifications!\");'><button class='action-button btn btn-danger'>Delete</button></a>";
						echo "<a href='/employees/edit?id=" . $employee->employee_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
					echo "</td>";
				}
			echo "</tr>";
		}
		?>
	</tbody>
</table>