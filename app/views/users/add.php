<h3>Add User</h3>

<form method="POST" action="">
	<div class="row edit-panel">
		<div class="col-md-6">
			<div>
				<label for="user_username">Username</label><br />
				<input type="text" name="user_username" id="user_username" />
			</div>
			
			<div>
				<label for="user_password">Password</label><br />
				<input type="password" name="user_password" id="user_username" />
			</div>
			
			<?php
			if($_SESSION['user']['user_admin'] == 1) {
				if($data['user']->user_admin == 1) {
					$checked = "checked";
				} else {
					$checked = "";
				}
				?>
				<div>
					<label for="user_admin">Admin (this user will be able to add and edit users)</label><br />
					<input <?php echo $checked; ?> type="checkbox" name="user_admin" id="user_admin" />
				</div>
				<?php
			}
			?>
			
		</div>
		<div class="col-md-6">
			<div>
				<label for="user_level">Access Levels</label><br />
				<div>
					<label for="user_food_access">Food Products</label><br />
					<select name="user_food_access" id="user_food_access">
						<option value="0">No Access</option>
						<option value="1">Can View</option>
						<option value="2">Can Edit</option>
					</select>
				</div>
				
				<div>
					<label for="user_employees_access">Employees</label><br />
					<select name="user_employees_access" id="user_employee_access">
						<option value="0">No Access</option>
						<option value="1">Can View</option>
						<option value="2">Can Edit</option>
					</select>
				</div>
				
				<div>
					<label for="user_healthsafety_access">Health &amp; Safety</label><br />
					<select name="user_healthsafety_access" id="user_healthsafety_access">
						<option value="0">No Access</option>
						<option value="1">Can View</option>
						<option value="2">Can Edit</option>
					</select>
				</div>

			<div>
				<button  class="btn btn-success" type="submit">Add User</button>
			</div>
		</div>
	</div>
</form>