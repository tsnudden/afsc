<h3>Users <a href="/users/add"><button class="btn btn-primary">Add User</button></a></h3>

<div class="search">
	<div class="search-title">
		SEARCH
	</div>
	<label for="keyword">Keyword</label><br />
	<input id="keyword" name="keyword" type="text" />
</div>
<table id="employees-table" class="table search-table table-hover table-striped table-bordered">
	<thead>
		<td>Username</td>
		<td>Access Level</td>
		<td>Actions</td>
	</thead>
	<tbody id="employees-body">
		<?php
		foreach($data['users'] as $user) {
			
			$access_string = "";
			
			switch($user->user_food_access) {
				case 1:
					$access_string .= "Food Products (view) ";
					break;
				case 2:
					$access_string .= "Food Products (edit) ";
					break;
			}
			switch($user->user_employees_access) {
				case 1:
					$access_string .= "Employees (view) ";
					break;
				case 2:
					$access_string .= "Employees (edit) ";
					break;
			}
			switch($user->user_healthsafety_access) {
				case 1:
					$access_string .= "Health & Safety (view) ";
					break;
				case 2:
					$access_string .= "Health & Safety (edit) ";
					break;
			}
			switch($user->user_operatingprocedures_access) {
				case 1:
					$access_string .= "Operating Procedures (view)";
					break;
				case 2:
					$access_string .= "Operating Procedures (edit)";
					break;
			}
			switch($user->is_admin) {
				case 1:
					$access_string .= ", Users (edit) ";
					break;
			}
			if($access_string == "") {
				$access_string = "No access";
			}
			$access_string = str_replace(") ", "), ", $access_string);
			?>
			<tr data-employee-name="">
				<td>
					<?php echo $user->user_username; ?>
				</td>
				<td>
					<?php echo $access_string; ?>
				</td>
				<td>
					<?php
					echo "<a href='/users/delete?id=" . $user->user_id . "' onclick='return confirm(\"Are you sure you want to delete this employee? This will also remove all attached qualifications!\");'><button class='action-button btn btn-danger'>Delete</button></a>";
					echo "<a href='/users/edit?id=" . $user->user_id . "'><button class='action-button btn btn-info'>Edit</button></a>";
					?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>